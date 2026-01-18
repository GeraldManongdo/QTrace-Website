<?php 
    $current_page = 'contractor'; 
    require('../../database/controllers/get_client_contractors.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Explore the official list of contractors involved in Quezon City government projects, showcasing their expertise and years of service."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Contractors List</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .contractor-card { border: none; border-radius: 15px; transition: all 0.3s ease; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .contractor-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        .logo-box { width: 55px; height: 55px; border-radius: 10px; overflow: hidden; background: #003366; display: flex; align-items: center; justify-content: center; color: white; }
        .logo-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .stat-badge { border-radius: 8px; padding: 10px; text-align: center; flex: 1; }
        .stat-active { background-color: #f0f3ff; color: #4f46e5; }
        .stat-completed { background-color: #f0fff4; color: #198754; }
        
        .rating-stars { color: #ffc107; font-size: 0.9rem; }
        .skill-badge { font-size: 0.75rem; background: #eef2ff; color: #4338ca; border-radius: 5px; padding: 3px 8px; margin: 2px; display: inline-block; }
        
        .btn-profile { background-color: #003366; color: white; font-weight: 600; border-radius: 8px; border: none; padding: 10px; transition: 0.2s; }
        .btn-profile:hover { background-color: #002244; color: white; }
        
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
                    <h2 class="fw-bold">Contractor List </h2>
                    <p class="text-muted">Official details of contractors involved in Quezon City government projects.</p>
                </div>

                <div class="card border-0 shadow-sm mb-3 p-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">SEARCH CONTRACTOR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="e.g. Metro Build or Drainage..." value="<?= htmlspecialchars($search) ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">MIN. EXPERIENCE</label>
                            <select name="min_years" class="form-select">
                                <option value="0">Any Experience</option>
                                <option value="5" <?= $min_years == 5 ? 'selected' : '' ?>>5+ Years</option>
                                <option value="10" <?= $min_years == 10 ? 'selected' : '' ?>>10+ Years</option>
                                <option value="20" <?= $min_years == 20 ? 'selected' : '' ?>>20+ Years</option>
                            </select>
                        </div>
                        <div class="col-md-3 ">
                            <button type="submit" class="btn bg-color-primary text-light w-100 fw-bold">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="row g-4">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card contractor-card rounded-2">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="logo-box me-3">
                                                <?php if($row['Contractor_Logo_Path']): ?>
                                                    <img src="<?= htmlspecialchars($row['Contractor_Logo_Path']) ?>" alt="Logo">
                                                <?php else: ?>
                                                    <i class="bi bi-building fs-3"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($row['Contractor_Name']) ?></h6>
                                                <small class="text-muted"><?= htmlspecialchars($row['Owner_Name']) ?></small>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted small">Based on <?= $row['Years_Of_Experience'] ?> years of service</small>
                                        </div>

                                        <div class="d-flex gap-2 mb-3">
                                            <div class="stat-badge stat-active">
                                                <div class="fw-bold h5 mb-0">--</div>
                                                <small class="small" style="font-size: 0.7rem;">Active Projects</small>
                                            </div>
                                            <div class="stat-badge stat-completed">
                                                <div class="fw-bold h5 mb-0">--</div>
                                                <small class="small" style="font-size: 0.7rem;">Completed</small>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="small mb-1 text-muted"><i class="bi bi-telephone me-2"></i><?= htmlspecialchars($row['Contact_Number']) ?></div>
                                            <div class="small text-muted text-truncate"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($row['Company_Email_Address']) ?></div>
                                        </div>

                                        <div class="mb-4" style="min-height: 60px;">
                                            <small class="text-muted d-block mb-1 fw-bold" style="font-size: 0.65rem;">EXPERTISE:</small>
                                            <?php 
                                                if($row['skills']) {
                                                    $skills = explode(', ', $row['skills']);
                                                    foreach(array_slice($skills, 0, 4) as $skill) {
                                                        echo '<span class="skill-badge">' . htmlspecialchars($skill) . '</span>';
                                                    }
                                                    if(count($skills) > 4) echo '<span class="skill-badge">+'.(count($skills)-4).'</span>';
                                                } else {
                                                    echo '<small class="text-muted italic">General Contractor</small>';
                                                }
                                            ?>
                                        </div>

                                        <a href="/QTrace-Website/contractors-details?id=<?= $row['Contractor_Id'] ?>" class="btn btn-profile w-100">View Full Profile</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-person-exclamation fs-1 text-muted"></i>
                            <p class="mt-3 text-muted">No contractors found matching your search.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Pagination Section -->
                <?php if ($total_pages > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-5 flex-wrap gap-3">
                    <!-- Results Info -->
                    <div class="pagination-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Showing <?= $start_from + 1 ?> to <?= min($start_from + $results_per_page, $total_records) ?> of <?= $total_records ?> contractors
                    </div>

                    <!-- Pagination Controls -->
                    <nav aria-label="Contractor pagination">
                        <ul class="pagination mb-0">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1)."&search=".urlencode($search)."&min_years=".$min_years : '#' ?>" aria-label="Previous">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php
                            // Smart pagination - show first, last, current and nearby pages
                            $range = 2; // Number of pages to show on each side of current page
                            
                            // Always show first page
                            if ($page > $range + 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&min_years='.$min_years.'">1</a></li>';
                                if ($page > $range + 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            // Show pages around current page
                            for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                                $active_class = ($page == $i) ? 'active' : '';
                                echo '<li class="page-item '.$active_class.'">
                                        <a class="page-link" href="?page='.$i.'&search='.urlencode($search).'&min_years='.$min_years.'">'.$i.'</a>
                                      </li>';
                            }

                            // Always show last page
                            if ($page < $total_pages - $range) {
                                if ($page < $total_pages - $range - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'&search='.urlencode($search).'&min_years='.$min_years.'">'.$total_pages.'</a></li>';
                            }
                            ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page < $total_pages) ? "?page=".($page + 1)."&search=".urlencode($search)."&min_years=".$min_years : '#' ?>" aria-label="Next">
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