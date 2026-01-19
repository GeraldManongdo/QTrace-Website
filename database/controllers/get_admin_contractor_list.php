<?php
require('../../database/connection/connection.php');

// 1. Get Filter/Search Inputs
$search_skill = isset($_GET['skill']) ? $conn->real_escape_string($_GET['skill']) : '';
$min_years = isset($_GET['min_years']) ? (int)$_GET['min_years'] : 0;

// 2. Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// 3. Build the count query
$countSql = "SELECT COUNT(DISTINCT c.Contractor_Id) as total 
            FROM contractor_table c
            LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
            WHERE 1=1";

if (!empty($search_skill)) {
    $countSql .= " AND c.Contractor_Id IN (
                SELECT Contractor_Id 
                FROM contractor_expertise_table 
                WHERE expertise 
                LIKE '%$search_skill%')";
}

if ($min_years > 0) {
    $countSql .= " AND c.Years_Of_Experience >= $min_years";
}

// Get total records count
$countResult = $conn->query($countSql);
$totalRow = $countResult->fetch_assoc();
$total_records = $totalRow['total'];
$total_pages = ceil($total_records / $records_per_page);

// 4. Build the Relational Query with pagination
// We use LEFT JOIN so contractors show up even if they don't have expertise listed yet
$sql = "SELECT c.*, GROUP_CONCAT(e.Expertise SEPARATOR ', ') as skills 
        FROM contractor_table c
        LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
        WHERE 1=1";

if (!empty($search_skill)) {
    $sql .= " AND c.Contractor_Id IN (
                SELECT Contractor_Id 
                FROM contractor_expertise_table 
                WHERE expertise 
                LIKE '%$search_skill%')";
}

if ($min_years > 0) {
    $sql .= " AND c.Years_Of_Experience >= $min_years";
}

$sql .= " GROUP BY c.Contractor_Id ORDER BY c.Contractor_Id DESC LIMIT $records_per_page OFFSET $offset";
$result = $conn->query($sql);

// 5. Store pagination data
$pagination = [
    'current_page' => $page,
    'total_pages' => $total_pages,
    'total_records' => $total_records,
    'per_page' => $records_per_page
];
?>