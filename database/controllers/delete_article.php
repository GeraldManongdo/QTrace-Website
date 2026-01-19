<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../../database/connection/connection.php');

// Handle both GET and POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : 'delete';
    
    if ($article_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid article ID.']);
        exit();
    }
    
    if (!isset($_SESSION['user_ID'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in.']);
        exit();
    }
    
    // Verify article exists
    $article_check = $conn->query("SELECT article_ID FROM articles_table WHERE article_ID = $article_id");
    if (!$article_check || $article_check->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Article not found.']);
        exit();
    }
    
    if ($action === 'archive') {
        // Archive the article by setting status to 'Archived'
        $sql = "UPDATE articles_table SET article_status = 'Archived' WHERE article_ID = $article_id";
    } else {
        // Delete the article
        $sql = "DELETE FROM articles_table WHERE article_ID = $article_id";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => $action === 'archive' ? 'Article archived successfully!' : 'Article deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        error_log('Database error: ' . $conn->error);
    }
    exit();
}

// Handle GET request (old functionality)
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    $_SESSION['error'] = 'Invalid article ID.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

if (!isset($_SESSION['user_ID'])) {
    $_SESSION['error'] = 'You must be logged in to delete articles.';
    header('Location: /QTrace-Website/login');
    exit();
}

$article_check = $conn->query("SELECT article_ID FROM articles_table WHERE article_ID = $article_id");
if (!$article_check || $article_check->num_rows === 0) {
    $_SESSION['error'] = 'Article not found.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

$delete_sql = "DELETE FROM articles_table WHERE article_ID = $article_id";

if ($conn->query($delete_sql) === TRUE) {
    $_SESSION['success_message'] = 'Article deleted successfully!';
    header('Location: /QTrace-Website/project-articles');
    exit();
} else {
    $_SESSION['error'] = 'Error deleting article: ' . $conn->error;
    error_log('Database error: ' . $conn->error);
    header('Location: /QTrace-Website/project-articles');
    exit();
}
?>
