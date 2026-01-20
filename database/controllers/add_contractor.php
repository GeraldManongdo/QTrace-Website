<?php
// Database connection
require('../connection/connection.php');
require('audit_service.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        // Handle Logo Upload
       $logo_path = '';
        if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] == 0) {
            $logoDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/contractors/logos/";
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
            $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
            $safe_company_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_name);
            $filename = $safe_company_name . "_logo." . $ext;
            $logo_path = "/QTrace-Website/uploads/contractors/logos/" . $filename;
            move_uploaded_file($_FILES['company_logo']['tmp_name'], $logoDir . $filename);
        }
        
        //Insert Main Contractor Record
        $sql = "INSERT INTO contractor_table (
                    Contractor_Logo_Path, 
                    Contractor_Name, 
                    Owner_Name, 
                    Company_Address, 
                    Contact_Number, 
                    Company_Email_Address, 
                    Years_Of_Experience, 
                    Additional_Notes
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssis", $logo_path, $company_name, $owner_name, $address, $contact_number, $email, $years_experience, $notes);
        $stmt->execute();
        $contractor_id = $conn->insert_id;

if (!empty($_POST['expertise']) && is_array($_POST['expertise'])) {
    
    $stmtEx = $conn->prepare("INSERT INTO contractor_expertise_table (
                                Contractor_Id, 
                                Expertise
                                ) VALUES (?, ?)");
    
    foreach ($_POST['expertise'] as $skill) {
        $cleanSkill = trim($skill);
        
        if ($cleanSkill !== '') { // Check if it's not empty after trimming
            $stmtEx->bind_param("is", $contractor_id, $cleanSkill);
            
            if (!$stmtEx->execute()) {
                // This will help you see if the DB is rejecting the 2nd entry
                error_log("Insert failed: " . $stmtEx->error);
            }
        }
    }
}
        //Insert Legal Documents
        if (!empty($_FILES['document_files']['name'][0])) {
            $docDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/contractors/documents/";
            if (!is_dir($docDir)) mkdir($docDir, 0777, true);
            
            $stmtDoc = $conn->prepare("INSERT INTO contractor_documents_table (
                                            Contractor_Id, 
                                            Document_Type, 
                                            Document_Path
                                            ) VALUES (?, ?, ?)");
            
            foreach ($_FILES['document_files']['name'] as $key => $val) {
                if ($_FILES['document_files']['error'][$key] == 0) {
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
                    }
                }
            }
        }

        $conn->commit();

        // --- LOG AUDIT ACTIVITY ---
        $auditService = new AuditService($conn);
        $userId = $_SESSION['user_ID'] ?? null;
        
        // Prepare new values for audit log
        $newContractorVals = [
            'Company_Name' => $company_name,
            'Owner_Name' => $owner_name,
            'Company_Address' => $address,
            'Contact_Number' => $contact_number,
            'Company_Email' => $email,
            'Years_Of_Experience' => $years_experience,
            'Logo_Path' => $logo_path,
            'Additional_Notes' => $notes
        ];
        
        $auditService->log($userId, 'CREATE', 'Contractor', $contractor_id, null, $newContractorVals);

        $msg = urlencode("Contractor added successfully.");
        header("Location: /QTrace-Website/contractor-list?status=success&msg=$msg"); // Redirect after success
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}

?>