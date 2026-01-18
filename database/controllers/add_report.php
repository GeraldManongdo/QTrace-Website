<?php
/**
 * Add Report Controller
 * Creates a new parent report for a project
 */

session_start();
require_once(__DIR__ . '/../connection/connection.php');

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_ID'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectID = intval($_POST['project_id'] ?? 0);
    $userID = intval($_SESSION['user_ID']);
    $reportType = trim($_POST['report_type'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $evidenceURL = null;
    
    // Validate required fields
    if ($projectID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid project ID']);
        exit;
    }
    
    if (empty($reportType)) {
        echo json_encode(['success' => false, 'message' => 'Report type is required']);
        exit;
    }
    
    if (empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Description is required']);
        exit;
    }
    
    // Handle file upload if present
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/reports/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExtension = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $fileName = 'evidence_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['evidence']['tmp_name'], $targetPath)) {
                $evidenceURL = '/QTrace-Website/uploads/reports/' . $fileName;
            }
        }
    }
    
    // Insert parent report
    $sql = "INSERT INTO report_table 
            (Project_ID, user_ID, report_type, report_description, 
             report_evidencesPhoto_URL, report_status, reportParent_ID) 
            VALUES (?, ?, ?, ?, ?, 'open', NULL)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $projectID, $userID, $reportType, $description, $evidenceURL);
        
        if ($stmt->execute()) {
            $newReportID = $conn->insert_id;
            
            echo json_encode([
                'success' => true, 
                'message' => 'Report submitted successfully',
                'report_id' => $newReportID
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit report']);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        error_log("Report submission error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    } catch (mysqli_sql_exception $e) {
        error_log("MySQL error in add_report: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
