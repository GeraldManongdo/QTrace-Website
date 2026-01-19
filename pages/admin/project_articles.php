<?php 
    $page_name = 'project_articles'; 
    include('../../database/connection/security.php');
    require('../../database/controllers/get_articles.php');
    
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
        <meta name="description" content="Article compilation for Quezon City projects.">
        <meta name="author" content="ai-Deib">
        <title>QTrace — Articles</title>
        <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Project Styles -->
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
            /* Inquirer-style editorial cards */
            .news-hero { display: grid; grid-template-columns: 1fr; gap: 12px; }
            .news-hero .thumb { width: 100%; aspect-ratio: 16/9; border-radius: 12px; overflow: hidden; background: #eef0f3; }
            .news-hero .thumb img { width: 100%; height: 100%; object-fit: cover; }
            .news-hero .title { font-size: 1.25rem; font-weight: 800; }
            .news-hero .meta { color: #6b7280; }

            .news-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 12px; overflow: hidden; }
            @media (min-width: 992px) { .news-grid { grid-template-columns: repeat(12, 1fr); } }
            @media (max-width: 991.98px) { .news-grid { grid-template-columns: repeat(6, 1fr); } }
            @media (max-width: 575.98px) { .news-grid { grid-template-columns: repeat(2, 1fr); } }

            .news-card { grid-column: span 4; display: flex; gap: 10px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
            .news-card .thumb { width: 140px; height: 100%; max-height: 100px; background: #eef0f3; flex-shrink: 0; }
            .news-card .thumb img { width: 100%; height: 100%; object-fit: cover; }
            .news-card .body { padding: 10px; flex: 1; }
            .kicker { font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #6b7280; }
            .headline { font-weight: 700; }
            .meta { color: #6b7280; font-size: 12px; }
            .excerpt { color: #4b5563; font-size: 13px; }
            .project-heading { display: flex; align-items: center; justify-content: space-between; }
        </style>
    </head>
    <body style="background-color: var(--bg-light);">
        <div class="app-container">
            <?php include('../../components/header.php'); ?>

            <div class="content-area">
                <?php include('../../components/sideNavigation.php'); ?>

                <main class="main-view">
                    <div class="container-fluid">
                        <nav aria-label="breadcrumb">
                            <!-- Breadcrumb -->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/QTrace-Website/dashboard">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Articles</li>
                            </ol>
                        </nav>

                        <div class="row mb-2">
                            <div class="col">
                                <!-- Page Header -->
                                <h2 class="fw-bold">Articles</h2>
                                <p>Article, news, and updates compilation of Quezon City projects</p>
                            </div>
                        </div>

                        <?php if(isset($_SESSION['success_message'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= $_SESSION['success_message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

                        <div class="mb-3 d-flex justify-content-end">
                            <a class="btn btn-primary btn-sm" href="/QTrace-Website/add-article"><i class="bi bi-plus-lg me-1"></i> Add Article</a>
                        </div>

                        <!-- Articles List -->
                        <section class="card border-0 shadow-sm mb-4" id="articles-section">
                            <div class="card-body">
                                <div class="project-heading mb-3">
                                    <span class="fw-bold">All Articles</span>
                                </div>

                                <?php 
                                // Combine featured and regular articles
                                $all_articles = [];
                                if ($featured_article) {
                                    $all_articles[] = $featured_article;
                                }
                                if ($articles_result && $articles_result->num_rows > 0) {
                                    while($article = $articles_result->fetch_assoc()) {
                                        $all_articles[] = $article;
                                    }
                                }
                                ?>

                                <?php if (count($all_articles) > 0): ?>
                                    <?php 
                                    $first = true;
                                    foreach($all_articles as $article): 
                                        if ($first): 
                                            $first = false;
                                    ?>
                                    <!-- Hero Article (First) -->
                                    <div class="news-hero mb-3" style="cursor: pointer;" onclick="window.location.href='/QTrace-Website/view-article?id=<?= $article['article_ID'] ?>';">
                                        <div class="thumb">
                                            <?php if (!empty($article['article_photo_url'])): ?>
                                                <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="<?= htmlspecialchars($article['article_photo_url']) ?>" />
                                            <?php else: ?>
                                                <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="https://placehold.co/1280x720" />
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="kicker"><?= htmlspecialchars($article['article_type']) ?></div>
                                            <div class="title"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></div>
                                            <div class="meta">
                                                <?= htmlspecialchars($article['ProjectDetails_Barangay']) ?> • 
                                                <?= htmlspecialchars($article['author_name'] ?: 'Admin') ?> • 
                                                <?= date('Y-m-d', strtotime($article['article_created_at'])) ?>
                                            </div>
                                            <div class="excerpt"><?= htmlspecialchars(substr($article['article_description'], 0, 120)) ?>...</div>
                                        </div>
                                    </div>

                                    <div class="news-grid" id="articles-grid">
                                    <?php else: ?>
                                        <!-- Regular Article Cards -->
                                        <div class="news-card" style="cursor: pointer;" onclick="window.location.href='/QTrace-Website/view-article?id=<?= $article['article_ID'] ?>';">
                                            <div class="thumb">
                                                <?php if (!empty($article['article_photo_url'])): ?>
                                                    <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="<?= htmlspecialchars($article['article_photo_url']) ?>" />
                                                <?php else: ?>
                                                    <img alt="<?= htmlspecialchars($article['ProjectDetails_Title']) ?>" src="https://placehold.co/280x200" />
                                                <?php endif; ?>
                                            </div>
                                            <div class="body">
                                                <div class="kicker"><?= htmlspecialchars($article['article_type']) ?></div>
                                                <div class="headline"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></div>
                                                <div class="meta">
                                                    <?= htmlspecialchars($article['ProjectDetails_Barangay']) ?> • 
                                                    <?= htmlspecialchars($article['author_name'] ?: 'Admin') ?> • 
                                                    <?= date('Y-m-d', strtotime($article['article_created_at'])) ?>
                                                </div>
                                                <div class="excerpt"><?= htmlspecialchars(substr($article['article_description'], 0, 80)) ?>...</div>
                                                <div class="mt-2">
                                                    <?php 
                                                    $statusBadges = array(
                                                        'Published' => 'bg-success',
                                                        'Draft' => 'bg-warning text-dark'
                                                    );
                                                    $badgeClass = isset($statusBadges[$article['article_status']]) ? $statusBadges[$article['article_status']] : 'bg-secondary';
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($article['article_status']) ?></span>
                                                    <span class="badge bg-light text-dark"><?= formatBudget($article['ProjectDetails_Budget']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                                        <p class="mt-3 text-muted">No articles found. Click "Add Article" to create one.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </section>
                        <div class="d-flex justify-content-end mt-3" id="articles-pagination" data-page="1"></div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Scripts -->
        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            // Single pagination (5 per page) into unified grid
            (function() {
                const PAGE_SIZE = 5;
                const grid = document.getElementById('articles-grid');
                const pager = document.getElementById('articles-pagination');

                function renderPager(current, total) {
                    const prevDisabled = current <= 1;
                    const nextDisabled = current >= total;
                    let html = '<nav aria-label="Page navigation"><ul class="pagination pagination-sm mb-0">';
                    html += `<li class="page-item ${prevDisabled ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${Math.max(1, current-1)}">Prev</a></li>`;
                    for (let i = 1; i <= total; i++) {
                        html += `<li class="page-item ${i === current ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                    }
                    html += `<li class="page-item ${nextDisabled ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${Math.min(total, current+1)}">Next</a></li>`;
                    html += '</ul></nav>';
                    return html;
                }

                function paginate() {
                    if (!grid || !pager) return;
                    const cards = Array.from(grid.querySelectorAll('.news-card'));
                    const totalPages = Math.max(1, Math.ceil(cards.length / PAGE_SIZE));
                    let current = Number(pager.dataset.page || '1');
                    if (current > totalPages) current = 1;
                    cards.forEach((card, idx) => {
                        const pageIndex = Math.floor(idx / PAGE_SIZE) + 1;
                        card.classList.toggle('d-none', pageIndex !== current);
                    });
                    pager.innerHTML = renderPager(current, totalPages);
                    pager.querySelectorAll('[data-page]').forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();
                            const p = Number(link.getAttribute('data-page'));
                            pager.dataset.page = String(p);
                            paginate();
                        });
                    });
                }

                // Initialize
                paginate();
            })();
        </script>
    </body>
</html>
