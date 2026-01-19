<?php
// Database connection
require('../connection/connection.php');
require('audit_service.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_account.php?status=error");
    exit();
}

// Fetch old status for audit trail
$oldStatusQuery = "SELECT user_status FROM user_table WHERE user_ID = ?";
$stmtOld = $conn->prepare($oldStatusQuery);
$stmtOld->bind_param("i", $user_id);
$stmtOld->execute();
$oldResult = $stmtOld->get_result();
$oldData = $oldResult->fetch_assoc();
$oldStatus = $oldData ? $oldData['user_status'] : null;

// Activate user account
$stmt = $conn->prepare("UPDATE user_table SET user_status = 'active' WHERE user_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Log the activation to audit trail
$auditService = new AuditService($conn);
$currentUserId = $_SESSION['user_id'] ?? null;

$oldVals = ['user_status' => $oldStatus];
$newVals = ['user_status' => 'active'];

$auditService->log($currentUserId, 'UPDATE', 'User', $user_id, $oldVals, $newVals);

$msg = urlencode("Account activated successfully.");
header("Location: /QTrace-Website/pages/admin/list_account.php?status=success&msg=$msg");
exit();
?>
