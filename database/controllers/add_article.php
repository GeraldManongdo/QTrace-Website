<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../../database/connection/connection.php');
require('audit_service.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data with strict validation
    $project_id = isset($_POST['project']) ? (int)$_POST['project'] : 0;
    $report_type = isset($_POST['report_type']) ? $conn->real_escape_string(trim($_POST['report_type'])) : 'Article';
    $description = isset($_POST['description']) ? $conn->real_escape_string(trim($_POST['description'])) : '';
    $photo_url = isset($_POST['photo_url']) ? $conn->real_escape_string(trim($_POST['photo_url'])) : '';
    $status = isset($_POST['status']) ? $conn->real_escape_string(trim($_POST['status'])) : 'Draft';
    
    // File upload handling
    $upload_dir = '../../uploads/projects/articles/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_file_size = 5 * 1024 * 1024; // 5MB
    
    // Get current user ID from session
    $user_id = isset($_SESSION['user_ID']) ? (int)$_SESSION['user_ID'] : 0;

    // Comprehensive validation
    if ($project_id <= 0) {
        $_SESSION['error'] = 'Invalid project selected.';
        header('Location: /QTrace-Website/add-article');
        exit();
    }
    
    if (empty($description)) {
        $_SESSION['error'] = 'Description/Content is required.';
        header('Location: /QTrace-Website/add-article');
        exit();
    }
    
    if ($user_id <= 0) {
        $_SESSION['error'] = 'You must be logged in to add articles.';
        header('Location: /QTrace-Website/add-article');
        exit();
    }
    
    // Validate project exists
    $project_check = $conn->query("SELECT Project_ID FROM projects_table WHERE Project_ID = $project_id AND Project_Status != 'Disabled'");
    if (!$project_check || $project_check->num_rows === 0) {
        $_SESSION['error'] = 'Selected project does not exist or is disabled.';
        header('Location: /QTrace-Website/add-article');
        exit();
    }

    // Handle file upload
    if (!empty($_FILES['article_image']['name'])) {
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file = $_FILES['article_image'];
        $file_type = mime_content_type($file['tmp_name']);
        $file_size = $file['size'];

        // Validate file
        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error'] = 'Invalid file type. Please upload an image (JPG, PNG, GIF, WebP).';
            header('Location: /QTrace-Website/add-article');
            exit();
        }

        if ($file_size > $max_file_size) {
            $_SESSION['error'] = 'File size exceeds 5MB limit.';
            header('Location: /QTrace-Website/add-article');
            exit();
        }

        // Generate unique filename
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = 'article_' . $project_id . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $new_filename;
        $db_path = '/QTrace-Website/uploads/projects/articles/' . $new_filename;

        // Upload file
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $photo_url = $db_path;
        } else {
            $_SESSION['error'] = 'Failed to upload image. Please try again.';
            error_log('File upload error: ' . $file['error']);
            header('Location: /QTrace-Website/add-article');
            exit();
        }
    }

    // Validate at least one image source
    if (empty($photo_url)) {
        $_SESSION['error'] = 'Please provide either an uploaded image or image URL.';
        header('Location: /QTrace-Website/add-article');
        exit();
    }

    // Insert article into articles_table
    $sql = "INSERT INTO articles_table 
            (Project_ID, user_ID, article_type, article_description, article_photo_url, article_status) 
            VALUES 
            ($project_id, $user_id, '$report_type', '$description', '$photo_url', '$status')";

    if ($conn->query($sql) === TRUE) {
        $article_id = $conn->insert_id;
        
        // Log the creation to audit trail
        $auditService = new AuditService($conn);
        $userId = $_SESSION['user_ID'] ?? null;
        
        // Prepare new values for audit log
        $newArticleVals = [
            'Project_ID' => $project_id,
            'user_ID' => $user_id,
            'article_type' => $report_type,
            'article_description' => $description,
            'article_photo_url' => $photo_url,
            'article_status' => $status
        ];
        
        $auditService->log($userId, 'CREATE', 'Article', $article_id, null, $newArticleVals);
        
        $_SESSION['success_message'] = 'Article added successfully!';
        header('Location: /QTrace-Website/article-list?status=succes');
        exit();
    } else {
        $_SESSION['error'] = 'Error adding article. Please try again.';
        error_log('Article insert error: ' . $conn->error);
        header('Location: /QTrace-Website/add-article');
        exit();
    }
} else {
    header('Location: /QTrace-Website/add-article');
    exit();
}
?>
