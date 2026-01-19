<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../../database/connection/connection.php');
require('audit_service.php');

// Get article ID from URL
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    $_SESSION['error'] = 'Invalid article ID.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

// Verify user is logged in
if (!isset($_SESSION['user_ID'])) {
    $_SESSION['error'] = 'You must be logged in to delete articles.';
    header('Location: /QTrace-Website/login');
    exit();
}

// Verify article exists and fetch current status
$article_check = $conn->query("SELECT article_ID, article_status FROM articles_table WHERE article_ID = $article_id");
if (!$article_check || $article_check->num_rows === 0) {
    $_SESSION['error'] = 'Article not found.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

$article = $article_check->fetch_assoc();
$oldStatus = $article['article_status'];

// Update the article status to Draft instead of deleting
$update_sql = "UPDATE articles_table SET article_status = 'Draft' WHERE article_ID = $article_id";

if ($conn->query($update_sql) === TRUE) {
    // Log the action to audit trail
    $auditService = new AuditService($conn);
    $userId = $_SESSION['user_ID'] ?? null;
    
    $oldVals = ['article_status' => $oldStatus];
    $newVals = ['article_status' => 'Draft'];
    
    $auditService->log($userId, 'UPDATE', 'Article', $article_id, $oldVals, $newVals);
    
    $_SESSION['success_message'] = 'Article moved to Draft successfully!';
    header('Location: /QTrace-Website/project-articles');
    exit();
} else {
    $_SESSION['error'] = 'Error updating article: ' . $conn->error;
    error_log('Database error: ' . $conn->error);
    header('Location: /QTrace-Website/project-articles');
    exit();
}
?>
