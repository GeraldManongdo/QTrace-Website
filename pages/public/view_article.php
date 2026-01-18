<?php 
    $current_page = 'articles';
    include('../../database/connection/connection.php');
    require('../../database/controllers/get_article_detail.php');
    
    // Helper function to format budget
    function formatBudget($amount) {
        return '₱' . number_format($amount, 2);
    }
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Article detail view.">
        <meta name="author" content="ai-Deib">
        <title>QTrace - <?= htmlspecialchars($article['ProjectDetails_Title']) ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
            .article-hero { width: 100%; max-height: 500px; border-radius: 12px; overflow: hidden; background: #eef0f3; margin-bottom: 2rem; }
            .article-hero img { width: 100%; height: 100%; object-fit: cover; }
            .article-meta { display: flex; flex-wrap: wrap; gap: 1rem; margin: 1rem 0; }
            .article-meta-item { display: flex; align-items: center; gap: 0.5rem; }
            .article-content { font-size: 1rem; line-height: 1.8; color: #4b5563; margin: 2rem 0; }
            .article-content p { margin-bottom: 1rem; }
            .article-header { padding: 2rem 0; border-bottom: 2px solid #e9ecef; margin-bottom: 2rem; }
            .article-header-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #6b7280; margin-bottom: 0.5rem; }
            .article-header-project { font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 0.5rem; }
            .article-header-location { font-size: 0.95rem; color: #6b7280; margin-bottom: 1rem; }
            .article-header-budget { font-size: 0.95rem; font-weight: 600; color: #374151; }
            .article-footer { background-color: #f8f9fa; padding: 2rem; border-radius: 8px; border-top: 2px solid #e9ecef; margin-top: 2rem; }
            .article-footer-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #6b7280; margin-bottom: 1rem; }
            .article-footer-item { font-size: 0.75rem; margin-bottom: 1.5rem; }
            .article-footer-label { font-weight: 600; color: #374151; margin-bottom: 0.25rem; }
            .article-footer-value { color: #1f2937; }
        </style>
    </head>
    <body class="bg-color-background">

        <?php include('../../components/topNavigation.php'); ?>

        <main>
            <section class="container py-5">
                <div class="title-section mb-4">
                    <h2 class="fw-bold"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></h2>
                    <p class="text-muted"></p>
                </div>

                <nav class="mb-3" aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/QTrace-Website/articles">Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></li>
                    </ol>
                </nav>

                <article class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Article Image -->
                        <?php if (!empty($article['article_photo_url'])): ?>
                            <div class="article-hero">
                                <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="<?= htmlspecialchars($article['article_photo_url']) ?>" />
                            </div>
                        <?php endif; ?>

                        <!-- Article Type, Author, Date Meta -->
                        <header class="mb-2">
                            <div class="article-header-title">Project</div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="article-header-project"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></div>
                                <span class="badge bg-info text-dark mb-2"><?= htmlspecialchars($article['article_type']) ?></span>
                            </div>

                            <div class="article-header-location">
                                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($article['ProjectDetails_Barangay']) ?>
                            </div>
                            <div class="article-header-budget">
                                Budget: <?= formatBudget($article['ProjectDetails_Budget']) ?>
                            </div>
                        </header>

                        <!-- Article Content -->
                        <div class="article-content">
                            <?= nl2br(htmlspecialchars($article['article_description'])) ?>
                        </div>

                        <!-- Article Footer with Credentials -->
                        <div class="article-footer">
                            <div class="article-footer-title">Article Details</div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="article-footer-item">
                                        <div class="article-footer-label">Publisher:</div>
                                        <div class="article-footer-value"><?= htmlspecialchars($article['author_name'] ?: 'Admin') ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="article-footer-item">
                                        <div class="article-footer-label">Created:</div>
                                        <div class="article-footer-value"><?= date('M d, Y H:i', strtotime($article['article_created_at'])) ?></div>
                                    </div>
                                </div>
                                <?php if ($article['article_updated_at'] !== $article['article_created_at']): ?>
                                    <div class="col-md-6">
                                        <div class="article-footer-item">
                                            <div class="article-footer-label">Updated:</div>
                                            <div class="article-footer-value"><?= date('M d, Y H:i', strtotime($article['article_updated_at'])) ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </main>

        <?php include('../../components/footer.php'); ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>
