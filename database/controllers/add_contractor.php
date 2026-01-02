<?php
// Database connection
require('../connection/connection.php');

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
            $logoDir = "../../uploads/logos/";
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);
            $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
            $safe_company_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $company_name);
            $filename = $safe_company_name . "_"."." . $ext;
            $logo_path = $logoDir . $filename;
            move_uploaded_file($_FILES['company_logo']['tmp_name'], $logo_path);
        }
        
        //Insert Main Contractor Record
        $sql = "INSERT INTO contractor_table (Contractor_Logo_Path, Contractor_Name, Owner_Name, Company_Address, Contact_Number, Company_Email_Address	, Years_Of_Experience, Additional_Notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssis", $logo_path, $company_name, $owner_name, $address, $contact_number, $email, $years_experience, $notes);
        $stmt->execute();
        $contractor_id = $conn->insert_id;

if (!empty($_POST['expertise']) && is_array($_POST['expertise'])) {
    
    $stmtEx = $conn->prepare("INSERT INTO contractor_expertise_table (Contractor_Id, Expertise) VALUES (?, ?)");
    
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
            $docDir = "../../uploads/documents/";
            if (!is_dir($docDir)) mkdir($docDir, 0777, true);
            
            $stmtDoc = $conn->prepare("INSERT INTO contractor_documents_table (Contractor_Id, Document_Type, Document_Path) VALUES (?, ?, ?)");
            
            foreach ($_FILES['document_files']['name'] as $key => $val) {
                if ($_FILES['document_files']['error'][$key] == 0) {
                    $docName = $_POST['document_names'][$key];
                    $tmpPath = $_FILES['document_files']['tmp_name'][$key];
                    $filePath = $docDir . time() . "_" . $_FILES['document_files']['name'][$key];
                    
                    if (move_uploaded_file($tmpPath, $filePath)) {
                        $stmtDoc->bind_param("iss", $contractor_id, $docName, $filePath);
                        $stmtDoc->execute();
                    }
                }
            }
        }

        $conn->commit();
        header("Location: ../../pages/admin/contractor_list.php"); // Redirect after success
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}

?>