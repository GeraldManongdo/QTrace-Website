<?php 
    $page_name = 'view_article'; 
    include('../../database/connection/security.php');
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
        <title>QTrace — <?= htmlspecialchars($article['ProjectDetails_Title']) ?></title>
        <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Project Styles -->
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
            .article-hero { width: 100%; max-height: 500px; border-radius: 12px; overflow: hidden; background: #eef0f3; margin-bottom: 2rem; }
            .article-hero img { width: 100%; height: 100%; object-fit: cover; }
            .article-meta { display: flex; flex-wrap: wrap; gap: 1rem; margin: 1rem 0; }
            .article-meta-item { display: flex; align-items: center; gap: 0.5rem; }
            .article-content { font-size: 1rem; line-height: 1.8; color: #4b5563; }
            .article-content p { margin-bottom: 1rem; }
        </style>
    </head>
    <body style="background-color: var(--bg-light);">
        <div class="app-container">
            <?php include('../../components/header.php'); ?>

            <div class="content-area">
                <?php include('../../components/sideNavigation.php'); ?>

                <main class="main-view">
                    <div class="container-fluid">
                        <nav class="mb-3" aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Admin</a></li>
                                <li class="breadcrumb-item"><a href="/QTrace-Website/project-articles">Articles</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></li>
                            </ol>
                        </nav>

                        <article class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <!-- Article Header -->
                                <header class="mb-4">
                                    <span class="badge bg-info text-dark mb-2"><?= htmlspecialchars($article['article_type']) ?></span>
                                    <h1 class="h2 fw-bold mb-2"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></h1>
                                    
                                    <div class="article-meta text-muted">
                                        <div class="article-meta-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <?= htmlspecialchars($article['ProjectDetails_Barangay']) ?>
                                        </div>
                                        <div class="article-meta-item">
                                            <i class="bi bi-person"></i>
                                            <?= htmlspecialchars($article['author_name'] ?: 'Admin') ?>
                                        </div>
                                        <div class="article-meta-item">
                                            <i class="bi bi-calendar"></i>
                                            <?= date('M d, Y', strtotime($article['article_created_at'])) ?>
                                        </div>
                                        <div class="article-meta-item">
                                            <?php 
                                            $statusBadges = array(
                                                'Published' => 'bg-success',
                                                'Draft' => 'bg-warning text-dark'
                                            );
                                            $badgeClass = isset($statusBadges[$article['article_status']]) ? $statusBadges[$article['article_status']] : 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($article['article_status']) ?></span>
                                        </div>
                                    </div>
                                </header>

                                <!-- Article Image -->
                                <?php if (!empty($article['article_photo_url'])): ?>
                                    <div class="article-hero">
                                        <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="<?= htmlspecialchars($article['article_photo_url']) ?>" />
                                    </div>
                                <?php endif; ?>

                                <!-- Article Content -->
                                <div class="article-content">
                                    <?= nl2br(htmlspecialchars($article['article_description'])) ?>
                                </div>

                                <!-- Project Info Section -->
                                <hr class="my-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h5 class="fw-bold">Project Information</h5>
                                        <p class="mb-2"><strong>Project:</strong> <?= htmlspecialchars($article['ProjectDetails_Title']) ?></p>
                                        <p class="mb-2"><strong>Budget:</strong> <?= formatBudget($article['ProjectDetails_Budget']) ?></p>
                                        <p><a href="/QTrace-Website/view-project?id=<?= $article['Project_ID'] ?>" class="btn btn-sm btn-outline-primary">View Project</a></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="fw-bold">Article Details</h5>
                                        <p class="mb-2"><strong>Created:</strong> <?= date('M d, Y H:i', strtotime($article['article_created_at'])) ?></p>
                                        <?php if ($article['article_updated_at'] !== $article['article_created_at']): ?>
                                            <p class="mb-2"><strong>Updated:</strong> <?= date('M d, Y H:i', strtotime($article['article_updated_at'])) ?></p>
                                        <?php endif; ?>
                                        <p class="mb-2"><strong>Type:</strong> <?= htmlspecialchars($article['article_type']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <!-- Navigation & Actions -->
                        <div class="d-flex gap-2 mt-4 justify-content-between">
                            <a href="/QTrace-Website/project-articles" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to Articles
                            </a>
                            <div class="d-flex gap-2">
                                <a href="/QTrace-Website/edit-article?id=<?= $article['article_ID'] ?>" class="btn btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Article
                                </a>
                                <button class="btn btn-warning" onclick="archiveArticle(<?= $article['article_ID'] ?>)">
                                    <i class="bi bi-archive me-1"></i> Archive
                                </button>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            function archiveArticle(articleId) {
                if (!confirm('Are you sure you want to archive this article?')) {
                    return;
                }

                const formData = new FormData();
                formData.append('article_id', articleId);
                formData.append('action', 'archive');

                fetch('/QTrace-Website/database/controllers/delete_article.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Article archived successfully!');
                        window.location.href = '/QTrace-Website/project-articles';
                    } else {
                        alert('Failed to archive article: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error archiving article. Please try again.');
                });
            }
        </script>
        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>
