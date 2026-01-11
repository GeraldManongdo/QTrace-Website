<?php
// Start the session to handle the timeout logic
session_start();

// 1. Session Timeout Logic (5 Minutes)
$timeout_duration = 300; // 300 seconds = 5 minutes

if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];
    if ($elapsed_time > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: /QTrace-Website/login?timeout");
        exit();
    }
}
// Update last activity time on every request
$_SESSION['last_activity'] = time();

// 2. Database connection
require('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture Information
    $first_name     = $_POST['first_name'];
    $middle_name    = $_POST['middle_name'];
    $last_name      = $_POST['last_name'];
    $sex            = $_POST['sex'];
    $birth_date     = $_POST['birth_date'];
    $role           = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email          = $_POST['email'];
    $main_address   = $_POST['main_address'];
    
    // SECURITY: Always hash passwords!
    $raw_password   = $_POST['defaultpassword'];
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // 3. Generate 11-digit Unique QC ID
    $isUnique = false;
    $qc_id_number = "";

    while (!$isUnique) {
        // Generates a cryptographically secure 11-digit number
        // We use random_int to ensure a wide spread of values
        $qc_id_number = (string)random_int(10000000000, 99999999999);

        // Check database for collisions
        $checkStmt = $conn->prepare("SELECT QC_ID_Number FROM user_table WHERE QC_ID_Number = ? LIMIT 1");
        $checkStmt->bind_param("s", $qc_id_number);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows == 0) {
            $isUnique = true; // No match found, safe to use
        }
        $checkStmt->close();
    }

    // 4. Begin Database Transaction
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
        
        // Bind parameters (11 strings)
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
            $hashed_password, 
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