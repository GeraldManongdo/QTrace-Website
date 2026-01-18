<?php
require('../../database/connection/connection.php');

// --- 1. CONFIGURATION ---
$results_per_page = 6; // 3x3 grid layout

// --- 2. GET INPUTS ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate Offset
$start_from = ($page - 1) * $results_per_page;

// --- 3. BUILD QUERY CONDITIONS ---
$whereClause = "WHERE 1=1";

if (!empty($search)) {
    $whereClause .= " AND (pd.ProjectDetails_Title LIKE '%$search%' 
               OR pd.ProjectDetails_Description LIKE '%$search%')";
}

if (!empty($status)) {
    $whereClause .= " AND p.Project_Status = '$status'";
}

if (!empty($category)) {
    $whereClause .= " AND p.Project_Category = '$category'";
}

// --- 4. GET TOTAL RECORDS (For Pagination Calculation) ---
$count_sql = "SELECT COUNT(p.Project_ID) as total 
              FROM projects_table p
              INNER JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
              $whereClause";

$count_result = $conn->query($count_sql);
$row_count = $count_result->fetch_assoc();
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $results_per_page);

// --- 5. GET DATA (With LIMIT and OFFSET) ---
$sql = "SELECT p.*, pd.* FROM projects_table p
        INNER JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        $whereClause
        ORDER BY p.Project_ID DESC
        LIMIT $start_from, $results_per_page";

$result = $conn->query($sql);

/**
 * Helper function for shorthand currency (K, M, B)
 */
function formatShorthand($n) {
    if ($n >= 1000000000) return round($n / 1000000000, 2) . 'B';
    if ($n >= 1000000) return round($n / 1000000, 2) . 'M';
    if ($n >= 1000) return round($n / 1000, 2) . 'K';
    return number_format($n);
}
?>