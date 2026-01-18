<?php
/**
 * Get Report Chat Controller
 * Retrieves parent report and all chat messages for a specific report
 */

require_once(__DIR__ . '/../connection/connection.php');

header('Content-Type: application/json');

if (isset($_GET['report_id'])) {
    $reportID = intval($_GET['report_id']);
    
    if ($reportID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid report ID']);
        exit;
    }
    
    // Get parent report with user info
    $sqlParent = "SELECT 
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
                    u.user_Role
                  FROM report_table r
                  LEFT JOIN user_table u ON r.user_ID = u.user_ID
                  WHERE r.report_ID = ? AND r.reportParent_ID IS NULL";
    
    try {
        $stmtParent = $conn->prepare($sqlParent);
        $stmtParent->bind_param("i", $reportID);
        $stmtParent->execute();
        $resultParent = $stmtParent->get_result();
        
        if ($resultParent->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Report not found']);
            exit;
        }
        
        $parent = $resultParent->fetch_assoc();
        $parent['username'] = trim($parent['FirstName'] . ' ' . $parent['LastName']);
        $parent['user_role'] = $parent['user_Role']; // Add lowercase for consistency
        unset($parent['FirstName'], $parent['LastName']);
        
        $stmtParent->close();
        
        // Get all chat messages
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
        $stmtMessages->bind_param("i", $reportID);
        $stmtMessages->execute();
        $resultMessages = $stmtMessages->get_result();
        
        $messages = [];
        while ($row = $resultMessages->fetch_assoc()) {
            $messages[] = [
                'report_ID' => $row['report_ID'],
                'user_ID' => $row['user_ID'],
                'username' => trim($row['FirstName'] . ' ' . $row['LastName']),
                'user_role' => $row['user_Role'],
                'report_description' => $row['report_description'],
                'report_evidencesPhoto_URL' => $row['report_evidencesPhoto_URL'],
                'report_CreatedAt' => $row['report_CreatedAt']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'parent' => $parent,
            'messages' => $messages,
            'message_count' => count($messages)
        ]);
        
        $stmtMessages->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Report ID is required']);
}

$conn->close();
?>
