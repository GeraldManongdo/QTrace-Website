<?php
// Database connection
require('../connection/connection.php');
require('audit_service.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture contractor_id
    $contractor_id = (int)$_POST['contractor_id'];
    
    if ($contractor_id <= 0) {
        die("Invalid contractor ID.");
    }

    // Fetch old values for audit trail
    $oldContractorQuery = "SELECT Contractor_Logo_Path, Contractor_Name, Owner_Name, Company_Address, 
                                Contact_Number, Company_Email_Address, Years_Of_Experience, Additional_Notes
                          FROM contractor_table WHERE Contractor_Id = ?";
    
    $stmtOld = $conn->prepare($oldContractorQuery);
    $stmtOld->bind_param("i", $contractor_id);
    $stmtOld->execute();
    $oldResult = $stmtOld->get_result();
    $oldValues = $oldResult->fetch_assoc();
    
    $oldContractorVals = $oldValues ? [
        'Company_Name' => $oldValues['Contractor_Name'],
        'Owner_Name' => $oldValues['Owner_Name'],
        'Company_Address' => $oldValues['Company_Address'],
        'Contact_Number' => $oldValues['Contact_Number'],
        'Company_Email' => $oldValues['Company_Email_Address'],
        'Years_Of_Experience' => $oldValues['Years_Of_Experience'],
        'Logo_Path' => $oldValues['Contractor_Logo_Path'],
        'Additional_Notes' => $oldValues['Additional_Notes']
    ] : null;

    // Capture Information
    $company_name     = $conn->real_escape_string($_POST['company_name']);
    $owner_name       = $conn->real_escape_string($_POST['owner_name']);
    $address          = $conn->real_escape_string($_POST['business_address']);
    $contact_number   = $conn->real_escape_string($_POST['contact_number']);
    $email            = $conn->real_escape_string($_POST['email']);
    $years_experience = (int)$_POST['years_experience'];
    $notes            = $conn->real_escape_string($_POST['additional_notes']);

    // Begin Transaction
    $conn->begin_transaction();

    try {
        // Handle Logo Upload (only if new file is uploaded)
        $logo_path = null;
        if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] == 0) {
            $logoDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/contractors/logos/";
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
            $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
            $safe_company_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_name);
            $filename = $safe_company_name . "_logo." . $ext;
            $logo_path = "/QTrace-Website/uploads/contractors/logos/" . $filename;
            move_uploaded_file($_FILES['company_logo']['tmp_name'], $logoDir . $filename);
        }
        
        // Update Main Contractor Record
        if ($logo_path !== null) {
            // Update with new logo
            $sql = "UPDATE contractor_table SET 
                        Contractor_Logo_Path = ?,
                        Contractor_Name = ?, 
                        Owner_Name = ?, 
                        Company_Address = ?, 
                        Contact_Number = ?, 
                        Company_Email_Address = ?, 
                        Years_Of_Experience = ?, 
                        Additional_Notes = ?
                    WHERE Contractor_Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssisi", $logo_path, $company_name, $owner_name, $address, $contact_number, $email, $years_experience, $notes, $contractor_id);
        } else {
            // Update without changing logo
            $sql = "UPDATE contractor_table SET 
                        Contractor_Name = ?, 
                        Owner_Name = ?, 
                        Company_Address = ?, 
                        Contact_Number = ?, 
                        Company_Email_Address = ?, 
                        Years_Of_Experience = ?, 
                        Additional_Notes = ?
                    WHERE Contractor_Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssisi", $company_name, $owner_name, $address, $contact_number, $email, $years_experience, $notes, $contractor_id);
        }
        $stmt->execute();

        // Update Expertise - Delete old ones and insert new ones
        $conn->query("DELETE FROM contractor_expertise_table WHERE Contractor_Id = $contractor_id");
        
        if (!empty($_POST['expertise']) && is_array($_POST['expertise'])) {
            $stmtEx = $conn->prepare("INSERT INTO contractor_expertise_table (
                                        Contractor_Id, 
                                        Expertise
                                        ) VALUES (?, ?)");
            
            foreach ($_POST['expertise'] as $skill) {
                $cleanSkill = trim($skill);
                
                if ($cleanSkill !== '') {
                    $stmtEx->bind_param("is", $contractor_id, $cleanSkill);
                    
                    if (!$stmtEx->execute()) {
                        error_log("Insert failed: " . $stmtEx->error);
                    }
                }
            }
        }

        // Insert New Legal Documents (if any)
        if (!empty($_FILES['document_files']['name'][0])) {
            $docDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/contractors/documents/";
            if (!is_dir($docDir)) mkdir($docDir, 0777, true);
            
            $stmtDoc = $conn->prepare("INSERT INTO contractor_documents_table (
                                            Contractor_Id, 
                                            Document_Type, 
                                            Document_Path
                                            ) VALUES (?, ?, ?)");
            
            foreach ($_FILES['document_files']['name'] as $key => $val) {
                if ($_FILES['document_files']['error'][$key] == 0 && !empty($_POST['document_names'][$key])) {
                    $docName = $_POST['document_names'][$key];
                    $tmpPath = $_FILES['document_files']['tmp_name'][$key];
                    $ext = pathinfo($_FILES['document_files']['name'][$key], PATHINFO_EXTENSION);
                    $safe_company = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_name);
                    $safe_doc = preg_replace('/[^A-Za-z0-9\-]/', '_', $docName);
                    $filename = $safe_company . "_" . $safe_doc . "." . $ext;
                    $filePath = "/QTrace-Website/uploads/contractors/documents/" . $filename;
                    
                    if (move_uploaded_file($tmpPath, $docDir . $filename)) {
                        $stmtDoc->bind_param("iss", $contractor_id, $docName, $filePath);
                        $stmtDoc->execute();
                        
                        // Log document upload to audit trail
                        $auditService = new AuditService($conn);
                        $userId = $_SESSION['user_id'] ?? null;
                        $docData = [
                            'Document_Type' => $docName,
                            'File_Name' => $filename,
                            'File_Location' => $filePath
                        ];
                        $auditService->log($userId, 'CREATE', 'ContractorDocument', $contractor_id, null, $docData);
                    }
                }
            }
        }

        $conn->commit();

        // --- LOG AUDIT ACTIVITY ---
        $auditService = new AuditService($conn);
        $userId = $_SESSION['user_id'] ?? null;
        
        // Prepare new values for audit log
        $newContractorVals = [
            'Company_Name' => $company_name,
            'Owner_Name' => $owner_name,
            'Company_Address' => $address,
            'Contact_Number' => $contact_number,
            'Company_Email' => $email,
            'Years_Of_Experience' => $years_experience,
            'Logo_Path' => $logo_path ?? $oldValues['Contractor_Logo_Path'],
            'Additional_Notes' => $notes
        ];
        
        $auditService->log($userId, 'UPDATE', 'Contractor', $contractor_id, $oldContractorVals, $newContractorVals);

        header("Location: /QTrace-Website/pages/admin/view_contractor.php?id=" . $contractor_id . "&status=updated");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}

?>
