<?php

if (!isset($conn)) {
    include(__DIR__ . '/../connection/connection.php');
}

// --- 1. CONFIGURATION ---
$results_per_page = 6; // Articles per page (excluding hero article)

// --- 2. GET PAGE ---
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate Offset
$start_from = ($page - 1) * $results_per_page;

// --- 3. GET FEATURED ARTICLE (NEWEST) ---
$featured_query = "
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
    WHERE a.article_status = 'Published'
    ORDER BY a.article_created_at DESC
    LIMIT 1
";

$featured_result = $conn->query($featured_query);
$featured_article = $featured_result ? $featured_result->fetch_assoc() : null;

// --- 4. GET TOTAL ARTICLES COUNT (excluding featured) ---
$count_query = "
    SELECT COUNT(a.article_ID) as total
    FROM articles_table a
    WHERE a.article_status = 'Published'
";

if ($featured_article) {
    $count_query .= " AND a.article_ID != " . intval($featured_article['article_ID']);
}

$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $results_per_page);

// --- 5. GET PAGINATED ARTICLES (excluding featured) ---
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
    WHERE a.article_status = 'Published'
";

if ($featured_article) {
    $articles_query .= " AND a.article_ID != " . intval($featured_article['article_ID']);
}

$articles_query .= " ORDER BY a.article_created_at DESC
    LIMIT $start_from, $results_per_page
";

$articles_result = $conn->query($articles_query);

if (!$articles_result) {
    error_log("Articles query error: " . $conn->error);
    $articles_result = null;
}
?>
