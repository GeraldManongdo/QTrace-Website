<?php
require('../../database/connection/connection.php');

// 1. Get Filter/Search Inputs
$search_skill = isset($_GET['skill']) ? $conn->real_escape_string($_GET['skill']) : '';
$min_years = isset($_GET['min_years']) ? (int)$_GET['min_years'] : 0;

// 2. Build the Relational Query
// We use LEFT JOIN so contractors show up even if they don't have expertise listed yet
$sql = "SELECT c.*, GROUP_CONCAT(e.Expertise SEPARATOR ', ') as skills 
        FROM contractor_table c
        LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
        WHERE 1=1";

if (!empty($search_skill)) {
    $sql .= " AND c.Contractor_Id IN (SELECT Contractor_Id FROM contractor_expertise_table WHERE expertise LIKE '%$search_skill%')";
}

if ($min_years > 0) {
    $sql .= " AND c.Years_Of_Experience >= $min_years";
}

$sql .= " GROUP BY c.Contractor_Id ORDER BY c.Contractor_Id DESC";
$result = $conn->query($sql);
?>