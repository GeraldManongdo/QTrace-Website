<?php
/**
 * Add Chat Message Controller
 * Creates a new chat message linked to a parent report
 */

session_start();
require_once(__DIR__ . '/../connection/connection.php');

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_ID'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentReportID = intval($_POST['parent_report_id'] ?? 0);
    $userID = intval($_SESSION['user_ID']);
    $message = trim($_POST['message'] ?? '');
    $attachmentURL = null;
    
    // Validate required fields
    if ($parentReportID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid report ID']);
        exit;
    }
    
    if (empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty']);
        exit;
    }
    
    // Get Project_ID from parent report
    $sqlProject = "SELECT Project_ID FROM report_table WHERE report_ID = ? AND reportParent_ID IS NULL";
    $stmtProject = $conn->prepare($sqlProject);
    $stmtProject->bind_param("i", $parentReportID);
    $stmtProject->execute();
    $result = $stmtProject->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Parent report not found']);
        exit;
    }
    
    $projectID = $result->fetch_assoc()['Project_ID'];
    $stmtProject->close();
    
    // Handle file upload if present
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/reports/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName = 'attachment_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
                $attachmentURL = '/QTrace-Website/uploads/reports/' . $fileName;
            }
        }
    }
    
    // Insert chat message
    $sql = "INSERT INTO report_table 
            (Project_ID, user_ID, report_description, 
             report_evidencesPhoto_URL, reportParent_ID) 
            VALUES (?, ?, ?, ?, ?)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissi", $projectID, $userID, $message, $attachmentURL, $parentReportID);
        
        if ($stmt->execute()) {
            $newMessageID = $conn->insert_id;
            
            echo json_encode([
                'success' => true, 
                'message' => 'Message sent successfully',
                'message_id' => $newMessageID
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send message']);
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
