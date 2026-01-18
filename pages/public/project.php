<?php 
    $current_page = 'projects'; 
    require('../../database/controllers/get_client_project.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Explore the official list of Quezon City government projects, detailing their scope, budget, and timelines."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Project List</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .project-card { border: none; border-radius: 15px; transition: all 0.3s ease; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .project-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        /* Category Icon Box - matching contractor logo style */
        .category-box { width: 55px; height: 55px; border-radius: 10px; background: #003366; display: flex; align-items: center; justify-content: center; color: white; }
        
        /* Stat Boxes - matching contractor stat style */
        .stat-badge { border-radius: 8px; padding: 10px; text-align: center; flex: 1; }
        .stat-budget { background-color: #f0f3ff; color: #4f46e5; }
        .stat-timeline { background-color: #f0fff4; color: #198754; }

        /* Description Clamping */
        .description-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
            font-size: 0.85rem;
        }
        
        .btn-view { background-color: #003366; color: white; font-weight: 600; border-radius: 8px; border: none; padding: 10px; transition: 0.2s; }
        .btn-view:hover { background-color: #002244; color: white; }
        
        /* Pagination Styling */
        .pagination { gap: 5px; }
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
    </style>
    <body class="bg-color-background">

        <!-- Include Navigation -->
        <?php
            include('../../components/topNavigation.php');
        ?>

        <main>
            <section class="container py-5">
                <div class="title-section">
                    <h2 class="fw-bold">Project List </h2>
                    <p class="text-muted">Official details of Quezon City government projects.</p>
                </div>

                <div class="card border-0 shadow-sm mb-3 p-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">SEARCH PROJECT</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="e.g, Metro Build or Drainage..." value="<?= htmlspecialchars($search) ?>">
                            </div>
                        </div>
                            
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">STATUS</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="Ongoing" <?= $status == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                <option value="Completed" <?= $status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Planning" <?= $status == 'Planning' ? 'selected' : '' ?>>Planning</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">CATEGORY</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="Infrastructure" <?= $category == 'Infrastructure' ? 'selected' : '' ?>>Infrastructure</option>
                                <option value="Environmental" <?= $category == 'Environmental' ? 'selected' : '' ?>>Environmental</option>
                                <option value="Social Services" <?= $category == 'Social Services' ? 'selected' : '' ?>>Social Services</option>
                                <option value="Safety" <?= $category == 'Safety' ? 'selected' : '' ?>>Safety</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn bg-color-primary text-light w-100 fw-bold">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="row g-4">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card project-card rounded-2">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="category-box me-3">
                                                <i class="bi bi-building-fill fs-3"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h6 class="fw-bold mb-0 text-dark text-truncate mb-1"><?= htmlspecialchars($row['ProjectDetails_Title']) ?></h6>
                                                <div class="small text-muted text-truncate fs-8">
                                                    <i class="bi bi-geo-alt-fill text-primary" style="color: var(--primary) !important;"></i>
                                                    <?= htmlspecialchars($row['ProjectDetails_Barangay']) ?>, QC
                                                </div>
                                            </div>
                                        </div>

                                        <p class="description-clamp text-muted mb-4">
                                            <?= htmlspecialchars($row['ProjectDetails_Description']) ?>
                                        </p>

                                        <div class="d-flex gap-2 mb-3">
                                            <div class="stat-badge stat-budget">
                                                <div class="fw-bold h6 mb-0">₱<?= formatShorthand($row['ProjectDetails_Budget']) ?></div>
                                                <small class="small" style="font-size: 0.65rem;">Est. Budget</small>
                                            </div>
                                            <div class="stat-badge stat-timeline">
                                                <div class="fw-bold h6 mb-0"><?= date("M Y", strtotime($row['ProjectDetails_StartedDate'])) ?></div>
                                                <small class="small" style="font-size: 0.65rem;">Started</small>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <a href="/QTrace-Website/project-details?id=<?= $row['Project_ID'] ?>" class="btn btn-view w-100">View Project Details</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder-x fs-1 text-muted"></i>
                            <p class="mt-3 text-muted">No projects found matching your filters.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination Section -->
                <?php if ($total_pages > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-5 flex-wrap gap-3">
                    <!-- Results Info -->
                    <div class="pagination-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Showing <?= $start_from + 1 ?> to <?= min($start_from + $results_per_page, $total_records) ?> of <?= $total_records ?> projects
                    </div>

                    <!-- Pagination Controls -->
                    <nav aria-label="Project pagination">
                        <ul class="pagination mb-0">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1)."&search=".urlencode($search)."&status=".$status."&category=".$category : '#' ?>" aria-label="Previous">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php
                            // Smart pagination - show first, last, current and nearby pages
                            $range = 2; // Number of pages to show on each side of current page
                            
                            // Always show first page
                            if ($page > $range + 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&status='.$status.'&category='.$category.'">1</a></li>';
                                if ($page > $range + 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            // Show pages around current page
                            for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                                $active_class = ($page == $i) ? 'active' : '';
                                echo '<li class="page-item '.$active_class.'">
                                        <a class="page-link" href="?page='.$i.'&search='.urlencode($search).'&status='.$status.'&category='.$category.'">'.$i.'</a>
                                      </li>';
                            }

                            // Always show last page
                            if ($page < $total_pages - $range) {
                                if ($page < $total_pages - $range - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'&search='.urlencode($search).'&status='.$status.'&category='.$category.'">'.$total_pages.'</a></li>';
                            }
                            ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page < $total_pages) ? "?page=".($page + 1)."&search=".urlencode($search)."&status=".$status."&category=".$category : '#' ?>" aria-label="Next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </section>
        </main>

        <!-- Include Footer -->
        <?php
            include('../../components/footer.php');
        ?>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>