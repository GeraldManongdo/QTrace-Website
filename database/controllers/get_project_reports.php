<?php

require_once(__DIR__ . '/../connection/connection.php');

header('Content-Type: application/json');

if (isset($_GET['project_id'])) {
    $projectID = intval($_GET['project_id']);
    
    if ($projectID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid project ID']);
        exit;
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
                u.user_firstName AS FirstName,
                u.user_lastName AS LastName,
                u.user_Role,
                (SELECT COUNT(*) FROM report_table WHERE reportParent_ID = r.report_ID) as message_count,
                (SELECT MAX(report_CreatedAt) FROM report_table WHERE reportParent_ID = r.report_ID) as last_message_time
            FROM report_table r
            LEFT JOIN user_table u ON r.user_ID = u.user_ID
            WHERE r.Project_ID = ? AND r.reportParent_ID IS NULL
            ORDER BY COALESCE(last_message_time, r.report_CreatedAt) DESC";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $projectID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $reports = [];
        while ($row = $result->fetch_assoc()) {
            $reports[] = [
                'report_ID' => $row['report_ID'],
                'Project_ID' => $row['Project_ID'],
                'user_ID' => $row['user_ID'],
                'username' => trim($row['FirstName'] . ' ' . $row['LastName']),
                'user_role' => $row['user_Role'],
                'report_type' => $row['report_type'],
                'report_description' => $row['report_description'],
                'report_evidencesPhoto_URL' => $row['report_evidencesPhoto_URL'],
                'report_status' => $row['report_status'],
                'report_CreatedAt' => $row['report_CreatedAt'],
                'message_count' => intval($row['message_count']),
                'last_activity' => $row['last_message_time'] ?? $row['report_CreatedAt']
            ];
        }
        
        echo json_encode([
            'success' => true, 
            'reports' => $reports,
            'count' => count($reports)
        ]);
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Project ID is required']);
}

$conn->close();
?>
