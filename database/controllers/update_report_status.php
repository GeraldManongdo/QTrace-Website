<?php
/**
 * Update Report Status Controller
 * Updates the status of a parent report (admin only)
 */

session_start();
require_once(__DIR__ . '/../connection/connection.php');

header('Content-Type: application/json');

// Check if user is logged in and is admin
if (!isset($_SESSION['user_ID']) || $_SESSION['user_Role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportID = intval($_POST['report_id'] ?? 0);
    $newStatus = trim($_POST['status'] ?? '');
    $adminID = intval($_SESSION['user_ID']);
    
    // Validate required fields
    if ($reportID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid report ID']);
        exit;
    }
    
    $allowedStatuses = ['open', 'in progress', 'resolved'];
    if (!in_array($newStatus, $allowedStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value']);
        exit;
    }
    
    // Update report status (only for parent reports)
    $sql = "UPDATE report_table 
            SET report_status = ?
            WHERE report_ID = ? AND reportParent_ID IS NULL";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $reportID);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // Add system message to chat
            $sqlProject = "SELECT Project_ID FROM report_table WHERE report_ID = ?";
            $stmtProject = $conn->prepare($sqlProject);
            $stmtProject->bind_param("i", $reportID);
            $stmtProject->execute();
            $projectID = $stmtProject->get_result()->fetch_assoc()['Project_ID'];
            $stmtProject->close();
            
            $systemMessage = "Status updated to: " . strtoupper($newStatus);
            $systemUserID = 0; // System user
            
            $sqlMessage = "INSERT INTO report_table 
                          (Project_ID, user_ID, report_description, reportParent_ID) 
                          VALUES (?, ?, ?, ?)";
            $stmtMessage = $conn->prepare($sqlMessage);
            $stmtMessage->bind_param("iisi", $projectID, $systemUserID, $systemMessage, $reportID);
            $stmtMessage->execute();
            $stmtMessage->close();
            
            echo json_encode([
                'success' => true, 
                'message' => 'Report status updated successfully',
                'new_status' => $newStatus
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Report not found or no changes made']);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
