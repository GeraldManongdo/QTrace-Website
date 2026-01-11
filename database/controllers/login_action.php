<?php
session_start();
require('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = $_POST['QC_ID_Number'] ?? '';
    $pass = $_POST['user_Password'] ?? '';

    if (empty($user) || empty($pass)) {
        header("Location: /QTrace-Website/login?error=empty_fields");
        exit();
    }

    // 1. Prepare statement - Added user_Role to the SELECT statement
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE 	QC_ID_Number  = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $user);
        $stmt->execute();
        
        // 2. Get the result
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $account = $result->fetch_assoc();

            // 3. Verify the hashed password
            if (password_verify($pass, $account['user_Password'])) {
                
                // Security: Prevent session fixation
                session_regenerate_id(true);
                
                // Store session data
                $_SESSION['user_ID'] = $account['user_ID'];
                $_SESSION['role'] = $account['user_Role'];
                
                // Initialize the 5-minute timer
                $_SESSION['last_activity'] = time();

                // Redirect based on role or to a general dashboard
                if($account['user_Role'] == 'admin')
                {
                    header("Location: /QTrace-Website/dashboard");
                    exit();
                }else{
                    header("Location: /QTrace-Website/home");
                    exit();
                }
            } else {
                // Password incorrect
                header("Location: /QTrace-Website/login?error=invalid_credentials");
                exit();
            }
        } else {
            // User ID not found
            header("Location: /QTrace-Website/login?error=invalid_credentials");
            exit();
        }
        $stmt->close();
    } else {
        die("Database error: " . $conn->error);
    }
}
?>