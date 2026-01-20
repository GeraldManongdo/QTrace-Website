<?php
session_start();
require('../connection/connection.php');
require_once('audit_service.php');

// Only allow POST submissions
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

$reportId = intval($_POST['report_id'] ?? 0);
$newStatus = trim($_POST['status'] ?? '');
$comment = trim($_POST['message'] ?? '');
$adminId = intval($_SESSION['user_ID'] ?? 0);

if ($reportId <= 0 || $adminId <= 0) {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

$conn->begin_transaction();

try {
    // Fetch the parent report to get current status and project
    $fetchSql = "SELECT Project_ID, report_status FROM report_table WHERE report_ID = ? AND reportParent_ID IS NULL LIMIT 1";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param('i', $reportId);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Report not found.');
    }

    $reportRow = $result->fetch_assoc();
    $projectId = intval($reportRow['Project_ID']);
    $currentStatus = $reportRow['report_status'];
    $fetchStmt->close();

    $statusChanged = $newStatus !== '' && strcasecmp($newStatus, $currentStatus) !== 0;
    $hasComment = $comment !== '';

    $oldVals = [];
    $newVals = [];

    // Update status when it changed
    if ($statusChanged) {
        $updateSql = "UPDATE report_table SET report_status = ? WHERE report_ID = ? AND reportParent_ID IS NULL";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('si', $newStatus, $reportId);
        if (!$updateStmt->execute()) {
            throw new Exception('Failed to update status.');
        }
        $updateStmt->close();

        $oldVals['report_status'] = $currentStatus;
        $newVals['report_status'] = $newStatus;
    }

    // Add comment if provided
    if ($hasComment) {
        $insertSql = "INSERT INTO report_table (Project_ID, user_ID, report_description, reportParent_ID) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('iisi', $projectId, $adminId, $comment, $reportId);
        if (!$insertStmt->execute()) {
            throw new Exception('Failed to add comment.');
        }
        $insertStmt->close();

        $newVals['comment'] = $comment;
    }

    // Audit the update (log only when something changed)
    if (!empty($newVals)) {
        $audit = new AuditService($conn);
        $audit->log($adminId, 'UPDATE', 'Report', $reportId, $oldVals ?: null, $newVals ?: null);
    }

    $conn->commit();

    $msg = urlencode('Report updated successfully.');
    header("Location: /QTrace-Website/pages/admin/view_report.php?id={$reportId}&status=success&msg={$msg}");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    $msg = urlencode('Error: ' . $e->getMessage());
    header("Location: /QTrace-Website/pages/admin/view_report.php?id={$reportId}&status=error&msg={$msg}");
    exit();
}

?>