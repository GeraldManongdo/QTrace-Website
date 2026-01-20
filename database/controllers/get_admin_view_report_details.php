<?php
require('../../database/connection/connection.php');
$reportId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($reportId <= 0) {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

$sql = "SELECT 
            r.report_ID,
            r.Project_ID,
            r.user_ID,
            r.report_type,
            r.report_description,
            r.report_evidencesPhoto_URL,
            r.report_status,
            r.report_CreatedAt,
            pd.ProjectDetails_Title,
            p.Project_Status,
            u.user_firstName AS FirstName,
            u.user_lastName AS LastName,
            u.user_Email,
            u.user_Role
        FROM report_table r
        LEFT JOIN projects_table p ON r.Project_ID = p.Project_ID
        LEFT JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        LEFT JOIN user_table u ON r.user_ID = u.user_ID
        WHERE r.report_ID = ? AND r.reportParent_ID IS NULL
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reportId);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();
$stmt->close();

if (!$report) {
    header('Location: /QTrace-Website/pages/admin/reports.php');
    exit();
}

// Auto-update status from "Sent" to "Seen" when viewing
if (strtolower($report['report_status']) === 'sent') {
    $updateSql = "UPDATE report_table SET report_status = 'Seen' WHERE report_ID = ? AND reportParent_ID IS NULL";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('i', $reportId);
    if ($updateStmt->execute()) {
        $report['report_status'] = 'Seen';
    }
    $updateStmt->close();
}

// Fetch all comments/replies for this report
$sqlMessages = "SELECT 
                    r.report_ID,
                    r.user_ID,
                    r.report_description,
                    r.report_evidencesPhoto_URL,
                    r.report_CreatedAt,
                    u.user_firstName AS FirstName,
                    u.user_lastName AS LastName,
                    u.user_Role
                FROM report_table r
                LEFT JOIN user_table u ON r.user_ID = u.user_ID
                WHERE r.reportParent_ID = ?
                ORDER BY r.report_CreatedAt ASC";

$stmtMessages = $conn->prepare($sqlMessages);
$stmtMessages->bind_param("i", $reportId);
$stmtMessages->execute();
$resultMessages = $stmtMessages->get_result();
$messages = [];
while ($row = $resultMessages->fetch_assoc()) {
    $messages[] = $row;
}
$stmtMessages->close();
?>