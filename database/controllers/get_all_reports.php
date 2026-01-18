<?php
/**
 * Get All Reports Controller (Admin)
 * Fetches all reports with filtering and search capabilities
 */

require_once(__DIR__ . '/../connection/connection.php');

// Initialize filters
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$type = $_GET['type'] ?? '';
$projectID = $_GET['project_id'] ?? '';

// Build SQL query with filters
$sql = "SELECT 
            r.report_ID,
            r.Project_ID,
            r.user_ID,
            r.report_type,
            r.report_description,
            r.report_evidencesPhoto_URL,
            r.report_status,
            r.report_CreatedAt,
            r.reportParent_ID,
            u.user_firstName AS FirstName,
            u.user_lastName AS LastName,
            u.user_Role,
            pd.ProjectDetails_Title,
            (SELECT COUNT(*) FROM report_table WHERE reportParent_ID = r.report_ID) as message_count
        FROM report_table r
        LEFT JOIN user_table u ON r.user_ID = u.user_ID
        LEFT JOIN projects_table p ON r.Project_ID = p.Project_ID
        LEFT JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        WHERE r.reportParent_ID IS NULL";

// Apply filters
if (!empty($search)) {
    $sql .= " AND (r.report_description LIKE ? OR r.report_type LIKE ? OR pd.ProjectDetails_Title LIKE ?)";
}

if (!empty($status)) {
    $sql .= " AND r.report_status = ?";
}

if (!empty($type)) {
    $sql .= " AND r.report_type = ?";
}

if (!empty($projectID)) {
    $sql .= " AND r.Project_ID = ?";
}

$sql .= " ORDER BY r.report_CreatedAt DESC";

try {
    $stmt = $conn->prepare($sql);
    
    // Bind parameters dynamically
    $params = [];
    $types = '';
    
    if (!empty($search)) {
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= 'sss';
    }
    
    if (!empty($status)) {
        $params[] = $status;
        $types .= 's';
    }
    
    if (!empty($type)) {
        $params[] = $type;
        $types .= 's';
    }
    
    if (!empty($projectID)) {
        $params[] = $projectID;
        $types .= 'i';
    }
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
} catch (Exception $e) {
    error_log("Error fetching reports: " . $e->getMessage());
    $result = null;
}

// Get unique report types for filter dropdown
$typesQuery = "SELECT DISTINCT report_type FROM report_table WHERE reportParent_ID IS NULL AND report_type IS NOT NULL ORDER BY report_type";
$typesResult = $conn->query($typesQuery);
$reportTypes = [];
if ($typesResult) {
    while ($row = $typesResult->fetch_assoc()) {
        $reportTypes[] = $row['report_type'];
    }
}

// Get all projects for filter dropdown
$projectsQuery = "SELECT p.Project_ID, pd.ProjectDetails_Title 
                  FROM projects_table p
                  INNER JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID 
                  ORDER BY pd.ProjectDetails_Title";
$projectsResult = $conn->query($projectsQuery);
$projects = [];
if ($projectsResult) {
    while ($row = $projectsResult->fetch_assoc()) {
        $projects[] = $row;
    }
}
?>
