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

// Pagination settings
$per_page = 10;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $per_page;

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

// Build parameters first (needed for both count and main query)
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

// Count total records for pagination
$countSql = "SELECT COUNT(*) as total
        FROM report_table r
        LEFT JOIN user_table u ON r.user_ID = u.user_ID
        LEFT JOIN projects_table p ON r.Project_ID = p.Project_ID
        LEFT JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        WHERE r.reportParent_ID IS NULL";

// Apply same filters to count query
if (!empty($search)) {
    $countSql .= " AND (r.report_description LIKE ? OR r.report_type LIKE ? OR pd.ProjectDetails_Title LIKE ?)";
}

if (!empty($status)) {
    $countSql .= " AND r.report_status = ?";
}

if (!empty($type)) {
    $countSql .= " AND r.report_type = ?";
}

if (!empty($projectID)) {
    $countSql .= " AND r.Project_ID = ?";
}

// Get total count
try {
    $countStmt = $conn->prepare($countSql);
    if (!empty($params)) {
        $countStmt->bind_param($types, ...$params);
    }
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $total_records = $countResult->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $per_page);
    $countStmt->close();
} catch (Exception $e) {
    error_log("Error counting reports: " . $e->getMessage());
    $total_records = 0;
    $total_pages = 0;
}

// Add LIMIT to main query
$sql .= " LIMIT ? OFFSET ?";

// Add pagination parameters to the params array
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';

try {
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Prepare pagination data
    $pagination = [
        'current_page' => $current_page,
        'per_page' => $per_page,
        'total_records' => $total_records,
        'total_pages' => $total_pages
    ];
    
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
