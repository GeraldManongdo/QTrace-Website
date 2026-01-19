<?php 
    $page_name = 'project_articles'; 
    include('../../database/connection/security.php');
    require('../../database/controllers/get_admin_articles_list.php');
    
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
        <meta name="description" content="Article compilation per project in an editorial card view.">
        <meta name="author" content="ai-Deib">
        <title>QTrace — Articles</title>
        <!-- Bootstrap & Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <!-- Project Styles -->
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
        </style>
    </head>
    <body style="background-color: var(--bg-light);">
        <div class="app-container">
            <?php include('../../components/header.php'); ?>

            <div class="content-area">
                <?php include('../../components/sideNavigation.php'); ?>

                <main class="main-view">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="text-uppercase small text-muted fw-bold">Articles</div>
                                <h1 class="h4 fw-bold m-0">Article Compilation by Project</h1>
                                <p class="text-muted m-0">Editorial card view inspired by Inquirer.net</p>
                                <nav class="mt-2" aria-label="breadcrumb">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Admin</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Articles</li>
                                    </ol>
                                </nav>
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

                        <!-- Articles List Table -->
                        <section class="card border-0 shadow-sm mb-4" id="articles-section">
                            <div class="table-responsive">
                                <?php if ($articles_result && $articles_result->num_rows > 0): ?>
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Type</th>
                                                <th>Project & Description</th>
                                                <th>Author</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Budget</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($article = $articles_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-info text-white"><?= htmlspecialchars($article['article_type']) ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold"><?= htmlspecialchars($article['ProjectDetails_Title']) ?></div>
                                                        <small class="text-muted"><?= htmlspecialchars($article['ProjectDetails_Barangay']) ?></small><br>
                                                        <small class="text-muted" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; display: block;"><?= htmlspecialchars(substr($article['article_description'], 0, 80)) ?>...</small>
                                                    </td>
                                                    <td>
                                                        <small><?= htmlspecialchars($article['author_name'] ?: 'Admin') ?></small>
                                                    </td>
                                                    <td>
                                                        <small><?= date('M d, Y', strtotime($article['article_created_at'])) ?></small>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $statusBadges = array(
                                                            'Published' => 'bg-success',
                                                            'Draft' => 'bg-warning text-dark'
                                                        );
                                                        $badgeClass = isset($statusBadges[$article['article_status']]) ? $statusBadges[$article['article_status']] : 'bg-secondary';
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($article['article_status']) ?></span>
                                                    </td>
                                                    <td>
                                                        <small><?= formatBudget($article['ProjectDetails_Budget']) ?></small>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="view_article.php?id=<?= $article['article_ID'] ?>" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                                                        <a href="edit_article.php?id=<?= $article['article_ID'] ?>" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteArticle(<?= $article['article_ID'] ?>)" title="Delete"><i class="bi bi-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                                        <p class="mt-3 text-muted">No articles found. Click "Add Article" to create one.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($articles_result && $articles_result->num_rows > 0 && isset($pagination)): ?>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing <?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1 ?> to 
                                            <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']) ?> 
                                            of <?= $pagination['total_records'] ?> articles
                                        </small>
                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <?php if ($pagination['current_page'] > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?>">Previous</a>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Previous</span>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <li class="page-item active disabled">
                                                    <span class="page-link"><?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?></span>
                                                </li>
                                                
                                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?>">Next</a>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="page-item disabled">
                                                        <span class="page-link">Next</span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </main>
            </div>
        </div>

        <!-- Scripts -->
        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            // Delete article function
            function deleteArticle(articleId) {
                if (confirm('Are you sure you want to delete this article?')) {
                    window.location.href = '/QTrace-Website/database/controllers/delete_article.php?id=' + articleId;
                }
            }
        </script>
    </body>
</html>
