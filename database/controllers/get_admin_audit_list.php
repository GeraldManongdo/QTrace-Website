<?php
// Database connection
require('../../database/connection/connection.php');

try {
    // 1. Collect filter values from GET request
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $actionFilter = isset($_GET['action']) ? trim($_GET['action']) : '';

    // 2. Pagination settings
    $records_per_page = 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    // 3. Base SQL Query for counting
    $countSql = "SELECT COUNT(*) as total
                FROM audit_logs a
                LEFT JOIN user_table u ON a.user_id = u.user_ID";

    // 4. Build dynamic WHERE clauses
    $whereClauses = [];
    $params = [];
    $types = "";

    // If search is not empty, search by name or ID
    if ($search !== '') {
        $whereClauses[] = "(u.user_firstName LIKE ? OR u.user_lastName LIKE ? OR a.user_id LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }

    // If an action is selected
    if ($actionFilter !== '') {
        $whereClauses[] = "a.action = ?";
        $params[] = $actionFilter;
        $types .= "s";
    }

    // Attach WHERE clauses to count query
    if (!empty($whereClauses)) {
        $countSql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    // Get total records count
    $stmtCount = $conn->prepare($countSql);
    if (!empty($params)) {
        $stmtCount->bind_param($types, ...$params);
    }
    $stmtCount->execute();
    $totalResult = $stmtCount->get_result();
    $totalRow = $totalResult->fetch_assoc();
    $total_records = $totalRow['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // 5. Base SQL Query for data
    $sql = "SELECT 
                a.audit_log_id, 
                a.user_id, 
                a.action, 
                a.resource_type, 
                a.resource_id, 
                a.old_values, 
                a.new_values, 
                a.created_at,
                u.user_firstName,
                u.user_lastName
            FROM audit_logs a
            LEFT JOIN user_table u ON a.user_id = u.user_ID";

    // Attach WHERE clauses to main query
    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    // Add Ordering and Pagination
    $sql .= " ORDER BY a.created_at DESC LIMIT ? OFFSET ?";

    // 6. Prepare and Execute
    $stmt = $conn->prepare($sql);

    // Add limit and offset to params
    $params[] = $records_per_page;
    $params[] = $offset;
    $types .= "ii";

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $audit_logs = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $audit_logs = [];
    }

    // 7. Store pagination data
    $pagination = [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_records' => $total_records,
        'per_page' => $records_per_page
    ];

} catch (Exception $e) {
    error_log("Audit List Error: " . $e->getMessage());
    $audit_logs = [];
    $total_records = 0;
    $total_pages = 0;
}