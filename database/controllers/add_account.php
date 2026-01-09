<?php
// Database connection
require('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture Information (Prepared statements handle escaping, so no need for real_escape_string)
    $first_name     = $_POST['first_name'];
    $middle_name    = $_POST['middle_name'];
    $last_name      = $_POST['last_name'];
    $sex            = $_POST['sex'];
    $birth_date     = $_POST['birth_date'];
    $role           = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email          = $_POST['email'];
    $main_address   = $_POST['main_address'];
    $password       = password_hash("defaultpassword", PASSWORD_BCRYPT);

    // 2. Generate 11-digit Unique QC ID
    $isUnique = false;
    $qc_id_number = "";

    while (!$isUnique) {
        // Generates 11 digits (3 digits + 8 digits)
        $qc_id_number = mt_rand(100, 999) . mt_rand(10000000, 99999999);

        // Check database for collisions
        $checkStmt = $conn->prepare("SELECT QC_ID_Number FROM user_table WHERE QC_ID_Number = ?");
        $checkStmt->bind_param("s", $qc_id_number);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows == 0) {
            $isUnique = true; // No match found, safe to use
        }
        $checkStmt->close();
    }

    // 3. Begin Database Transaction
    $conn->begin_transaction();
    
    try {    
        // Insert User Record
        $sql = "INSERT INTO user_table (
                    user_firstName, 
                    user_middleName, 
                    user_lastName, 
                    user_sex, 
                    user_birthDate, 
                    user_Role, 
                    user_contactInformation, 
                    user_Email,
                    user_address,
                    user_Password,
                    QC_ID_Number
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        // Bind all 11 strings
        $stmt->bind_param("sssssssssss", 
            $first_name, 
            $middle_name, 
            $last_name, 
            $sex, 
            $birth_date, 
            $role, 
            $contact_number, 
            $email, 
            $main_address, 
            $password, 
            $qc_id_number
        );

        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        $conn->commit();
        $stmt->close();
        
        // Redirect after success
        header("Location: ../../pages/admin/account_list.php?status=added"); 
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>