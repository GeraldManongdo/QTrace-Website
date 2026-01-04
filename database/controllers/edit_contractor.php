<?php
// Database connection
require('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['contractor_id'];
    $name = $_POST['company_name'];
    $owner = $_POST['owner_name'];
    $address = $_POST['business_address'];
    $contact = $_POST['contact_number'];
    $email = $_POST['email'];
    $experience = $_POST['years_experience'];
    $notes = $_POST['additional_notes'];

    // 1. Update Basic Information
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
    $stmt->bind_param("sssssisi", $name, $owner, $address, $contact, $email, $experience, $notes, $id);
    $stmt->execute();

    // 2. Handle Logo Upload (If a new one is selected)
    if (!empty($_FILES['company_logo']['name'])) {
        $target_dir = "../../assets/uploads/logos/";
        $file_ext = pathinfo($_FILES["company_logo"]["name"], PATHINFO_EXTENSION);
        $file_name = "logo_" . $id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {
            $update_logo = "UPDATE contractors SET Contractor_Logo_Path = ? WHERE Contractor_Id = ?";
            $logo_stmt = $conn->prepare($update_logo);
            $db_path = "/QTrace-Website/assets/uploads/logos/" . $file_name;
            $logo_stmt->bind_param("si", $db_path, $id);
            $logo_stmt->execute();
        }
    }

    // 3. Handle Expertise (Delete old and re-insert new)
    $del_exp = "DELETE FROM contractor_expertise_table WHERE Contractor_Id = ?";
    $del_stmt = $conn->prepare($del_exp);
    $del_stmt->bind_param("i", $id);
    $del_stmt->execute();

    if (isset($_POST['expertise'])) {
        $ins_exp = "INSERT INTO contractor_expertise_table (Contractor_Id, Expertise) VALUES (?, ?)";
        $exp_stmt = $conn->prepare($ins_exp);
        foreach ($_POST['expertise'] as $skill) {
            if (!empty($skill)) {
                $exp_stmt->bind_param("is", $id, $skill);
                $exp_stmt->execute();
            }
        }
    }

    // 4. Handle New Document Uploads
    if (isset($_FILES['document_files'])) {
        $doc_names = $_POST['document_names'];
        $doc_files = $_FILES['document_files'];

        for ($i = 0; $i < count($doc_files['name']); $i++) {
            if ($doc_files['error'][$i] === 0) {
                $doc_dir = "../../assets/uploads/documents/";
                $doc_ext = pathinfo($doc_files['name'][$i], PATHINFO_EXTENSION);
                $doc_name = "doc_" . $id . "_" . time() . "_" . $i . "." . $doc_ext;
                $doc_path = $doc_dir . $doc_name;

                if (move_uploaded_file($doc_files['tmp_name'][$i], $doc_path)) {
                    $db_doc_path = "/QTrace-Website/assets/uploads/documents/" . $doc_name;
                    $doc_type = !empty($doc_names[$i]) ? $doc_names[$i] : "Other";
                    
                    $ins_doc = "INSERT INTO contractor_documents (Contractor_Id, Document_Type, Document_Path) VALUES (?, ?, ?)";
                    $doc_stmt = $conn->prepare($ins_doc);
                    $doc_stmt->bind_param("iss", $id, $doc_type, $db_doc_path);
                    $doc_stmt->execute();
                }
            }
        }
    }

    // Redirect back with success message
    header("Location: /QTrace-Website/pages/admin/view_contractor?id=" . $id . "&status=updated");
    exit();
}
?>