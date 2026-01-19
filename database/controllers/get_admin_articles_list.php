<?php

if (!isset($conn)) {
    include(__DIR__ . '/../connection/connection.php');
}

// --- 1. CONFIGURATION ---
$results_per_page = 10; // Articles per page

// --- 2. GET PAGE ---
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate Offset
$start_from = ($page - 1) * $results_per_page;

// --- 3. GET TOTAL ARTICLES COUNT ---
$count_query = "
    SELECT COUNT(a.article_ID) as total
    FROM articles_table a
    WHERE a.article_status IN ('Published', 'Draft')
";

$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $results_per_page);

if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
    $start_from = ($page - 1) * $results_per_page;
}

// --- 4. GET PAGINATED ARTICLES ---
$articles_query = "
    SELECT 
        a.article_ID,
        a.article_type,
        a.article_description,
        a.article_photo_url,
        a.article_status,
        a.article_created_at,
        pt.Project_ID,
        pd.ProjectDetails_Title,
        pd.ProjectDetails_Barangay,
        pd.ProjectDetails_Budget,
        u.user_id,
        CONCAT(u.user_FirstName, ' ', u.user_LastName) as author_name
    FROM articles_table a
    INNER JOIN projects_table pt ON a.Project_ID = pt.Project_ID
    INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
    LEFT JOIN user_table u ON a.user_ID = u.user_id
    WHERE a.article_status IN ('Published', 'Draft')
    ORDER BY a.article_created_at DESC
    LIMIT $start_from, $results_per_page
";

$articles_result = $conn->query($articles_query);

if (!$articles_result) {
    error_log("Articles query error: " . $conn->error);
    $articles_result = null;
}

// --- 5. PAGINATION INFO ---
$pagination = array(
    'current_page' => $page,
    'total_pages' => $total_pages,
    'total_records' => $total_records,
    'per_page' => $results_per_page
);
?>
