<?php
require('../../database/connection/connection.php');

// 1. Capture the search input from the GET request
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 2. Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// 3. Build the base query for counting total records
$countQuery = "SELECT COUNT(*) as total FROM user_table";

// 4. Add filter logic if search is not empty
if (!empty($search)) {
    $countQuery .= " WHERE user_lastName LIKE ? 
                    OR user_firstName LIKE ? 
                    OR QC_ID_Number LIKE ?";
}

// 5. Get total records count
$stmtCount = $conn->prepare($countQuery);
if (!empty($search)) {
    $searchTerm = "%$search%";
    $stmtCount->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}
$stmtCount->execute();
$totalResult = $stmtCount->get_result();
$totalRow = $totalResult->fetch_assoc();
$total_records = $totalRow['total'];
$total_pages = ceil($total_records / $records_per_page);

// 6. Build the main query with pagination
$query = "SELECT * FROM user_table";

// 7. Add filter logic if search is not empty
if (!empty($search)) {
    // We check all three columns for a partial match
    $query .= " WHERE user_lastName LIKE ? 
                OR user_firstName LIKE ? 
                OR QC_ID_Number LIKE ?";
}

// 8. Add the ordering and pagination at the end
$query .= " ORDER BY user_status ASC, user_ID ASC LIMIT ? OFFSET ?";

// 9. Prepare and execute the statement
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $searchTerm = "%$search%";
    // We bind the same search term to all three '?' placeholders plus limit and offset
    $stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $records_per_page, $offset);
} else {
    $stmt->bind_param("ii", $records_per_page, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// 10. Store pagination data
$pagination = [
    'current_page' => $page,
    'total_pages' => $total_pages,
    'total_records' => $total_records,
    'per_page' => $records_per_page
];
?>