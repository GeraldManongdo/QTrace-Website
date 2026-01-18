<?php
require('../../database/connection/connection.php');

// --- 1. CONFIGURATION ---
$results_per_page = 6; 

// --- 2. GET INPUTS ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$min_years = isset($_GET['min_years']) ? (int)$_GET['min_years'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate Offset
$start_from = ($page - 1) * $results_per_page;

// --- 3. BUILD QUERY CONDITIONS ---
// We build the WHERE clause separately so we can reuse it for both the DATA query and the COUNT query
$whereClause = "WHERE 1=1";

if (!empty($search)) {
    $whereClause .= " AND (c.Contractor_Name LIKE '%$search%' 
                       OR c.Owner_Name LIKE '%$search%'
                       OR c.Contractor_Id IN (SELECT Contractor_Id FROM contractor_expertise_table WHERE Expertise LIKE '%$search%'))";
}

if ($min_years > 0) {
    $whereClause .= " AND c.Years_Of_Experience >= $min_years";
}

// --- 4. GET TOTAL RECORDS (For Pagination Calculation) ---
// We need to know the total rows *before* LIMITing to calculate total pages
$count_sql = "SELECT COUNT(DISTINCT c.Contractor_Id) as total 
              FROM contractor_table c
              LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
              $whereClause";

$count_result = $conn->query($count_sql);
$row = $count_result->fetch_assoc();
$total_records = $row['total'];
$total_pages = ceil($total_records / $results_per_page);

// --- 5. GET DATA (With LIMIT and OFFSET) ---
$sql = "SELECT c.*, GROUP_CONCAT(e.Expertise SEPARATOR ', ') as skills 
        FROM contractor_table c
        LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
        $whereClause
        GROUP BY c.Contractor_Id 
        ORDER BY c.Years_Of_Experience DESC
        LIMIT $start_from, $results_per_page"; // <--- Pagination magic happens here

$result = $conn->query($sql);
?>