<?php 
    $current_page = 'articles';
    include('../../database/connection/connection.php');
    require('../../database/controllers/get_articles.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Public articles compilation in an editorial card view.">
        <meta name="author" content="ai-Deib">
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Articles</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
            .hero-section {
                background: linear-gradient(rgba(26, 57, 91, 0.9), rgba(31, 57, 85, 0.8)),
                    url('/QTrace-Website/assets/image/Hero-Bg.jpg');
                background-repeat: no-repeat;
                background-position: center center;
                background-size: cover;
                min-height: 300px;
                display: flex;
                align-items: center;
                color: white;
            }
            .search-bar {
                border-radius: 10px;
                padding: 15px 25px;
                border: none;
            }
            
            /* Featured Article */
            .featured-article {
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                cursor: pointer;
                border: none;
                margin-bottom: 3rem;
            }
            .featured-article:hover {
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
                transform: translateY(-5px);
            }
            .featured-article-image {
                width: 100%;
                height: 350px;
                object-fit: cover;
                display: block;
            }
            .featured-article-content {
                padding: 2rem;
            }
            .featured-badge {
                display: inline-block;
                background: #003366;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 0.75rem;
                text-transform: uppercase;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .featured-title {
                font-size: 2rem;
                font-weight: 800;
                margin: 1rem 0;
                color: #1a395b;
                line-height: 1.2;
            }
            .featured-meta {
                color: #6b7280;
                font-size: 0.95rem;
                margin-bottom: 1rem;
            }
            .featured-excerpt {
                color: #4b5563;
                font-size: 1rem;
                line-height: 1.6;
            }
            
            /* Articles Grid */
            .articles-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
                margin-bottom: 3rem;
            }
            @media (max-width: 768px) {
                .articles-grid {
                    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                    gap: 1.5rem;
                }
            }
            @media (max-width: 576px) {
                .articles-grid {
                    grid-template-columns: 1fr;
                }
            }
            
            /* Article Card */
            .article-card {
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                cursor: pointer;
                border: none;
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .article-card:hover {
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
                transform: translateY(-5px);
            }
            .article-card-image {
                width: 100%;
                height: 200px;
                object-fit: cover;
                display: block;
            }
            .article-card-body {
                padding: 1.5rem;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            .article-card-badge {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                color: #003366;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .article-card-title {
                font-weight: 700;
                font-size: 1.1rem;
                margin-bottom: 0.75rem;
                color: #1a395b;
                line-height: 1.3;
            }
            .article-card-meta {
                color: #6b7280;
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            .article-card-excerpt {
                color: #4b5563;
                font-size: 0.9rem;
                line-height: 1.5;
                flex-grow: 1;
                margin-bottom: 1rem;
            }
            .article-card-status {
                align-self: flex-start;
            }
            
            /* Pagination */
            .pagination {
                gap: 5px;
            }
            .pagination .page-link {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                color: #003366;
                font-weight: 500;
                padding: 8px 16px;
                transition: all 0.2s ease;
            }
            .pagination .page-link:hover {
                background-color: #003366;
                color: white;
                border-color: #003366;
            }
            .pagination .page-item.active .page-link {
                background-color: #003366;
                border-color: #003366;
                color: white;
                font-weight: 600;
            }
            .pagination .page-item.disabled .page-link {
                color: #6c757d;
                background-color: #f8f9fa;
                border-color: #dee2e6;
            }
            .pagination-info {
                color: #6c757d;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
            }
            .badge-qc {
            background-color: var(--accent);
            color: #333;
            border-radius: 50px;
        }
            
        </style>
    </head>
    <body class="bg-color-background">

        <?php include('../../components/topNavigation.php'); ?>

        <main>
            <section class="hero-section">
                <div class="container text-center">
                    <span class="badge badge-qc mb-3 fw-normal py-2 px-3 fs-6"> Articles</span>
                    <h1 class="display-5 fw-medium">Project Articles</h1>
                    <p class="lead mb-5 fw-normal fs-5 w-75 m-auto">
                        Stay informed with the latest updates and stories from our community projects.
                    </p>
                </div>
            </section>
            <section class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="title-section">
                        <h2 class="fw-bold">Latest Project Updates </h2>
                        <p class="text-muted">Stay informed with news from our community projects.</p>
                    </div>
                </div>

                <!-- Featured Article Section -->
                <?php if ($featured_article): ?>
                <div class="featured-article" onclick="window.location.href='/QTrace-Website/article?id=<?= $featured_article['article_ID'] ?>';">
                    <div>
                        <img alt="<?= htmlspecialchars($featured_article['ProjectDetails_Title']) ?>" 
                             class="featured-article-image"
                             src="<?= !empty($featured_article['article_photo_url']) ? htmlspecialchars($featured_article['article_photo_url']) : 'https://placehold.co/1200x400' ?>" />
                    </div>
                    <div class="featured-article-content">
                        <div class="featured-badge"><?= htmlspecialchars($featured_article['article_type']) ?></div>
                        <h2 class="featured-title"><?= htmlspecialchars($featured_article['ProjectDetails_Title']) ?></h2>
                        <div class="featured-meta">
                            <i class="bi bi-geo-alt me-2"></i><?= htmlspecialchars($featured_article['ProjectDetails_Barangay']) ?> • 
                            <i class="bi bi-person me-2"></i><?= htmlspecialchars($featured_article['author_name'] ?: 'Admin') ?> • 
                            <i class="bi bi-calendar me-2"></i><?= date('M d, Y', strtotime($featured_article['article_created_at'])) ?>
                        </div>
                        <p class="featured-excerpt"><?= htmlspecialchars(substr($featured_article['article_description'], 0, 200)) ?>...</p>
                        <div class="mt-3">
                            <span class="badge bg-primary">Featured Article</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Articles Grid -->
                <?php if ($articles_result && $articles_result->num_rows > 0): ?>
                <div class="articles-grid">
                    <?php while($article = $articles_result->fetch_assoc()): ?>
                    <div class="article-card" onclick="window.location.href='/QTrace-Website/article?id=<?= $article['article_ID'] ?>';">
                        <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" 
                             class="article-card-image"
                             src="<?= !empty($article['article_photo_url']) ? htmlspecialchars($article['article_photo_url']) : 'https://placehold.co/400x300' ?>" />
                        <div class="article-card-body">
                            <div class="article-card-badge"><?= htmlspecialchars($article['article_type']) ?></div>
                            <h3 class="article-card-title"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></h3>
                            <div class="article-card-meta">
                                <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($article['ProjectDetails_Barangay']) ?> • 
                                <i class="bi bi-calendar me-1"></i><?= date('M d, Y', strtotime($article['article_created_at'])) ?>
                            </div>
                            <p class="article-card-excerpt"><?= htmlspecialchars(substr($article['article_description'], 0, 100)) ?>...</p>
                            <div class="article-card-status">
                                <span class="badge bg-success">Read More</span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-5 flex-wrap gap-3">
                    <div class="pagination-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Showing <?= $start_from + 1 ?> to <?= min($start_from + $results_per_page, $total_records) ?> of <?= $total_records ?> articles
                    </div>

                    <nav aria-label="Articles pagination">
                        <ul class="pagination mb-0">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1) : '#' ?>" aria-label="Previous">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php
                            // Smart pagination
                            $range = 2;
                            
                            if ($page > $range + 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                if ($page > $range + 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                                $active_class = ($page == $i) ? 'active' : '';
                                echo '<li class="page-item '.$active_class.'">
                                        <a class="page-link" href="?page='.$i.'">'.$i.'</a>
                                      </li>';
                            }

                            if ($page < $total_pages - $range) {
                                if ($page < $total_pages - $range - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
                            }
                            ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page < $total_pages) ? "?page=".($page + 1) : '#' ?>" aria-label="Next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">No articles found.</p>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </main>

        <?php include('../../components/footer.php'); ?>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>
