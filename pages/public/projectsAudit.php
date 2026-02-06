<?php
    session_start();
    $current_page = 'audit'; 
    require('../../database/controllers/get_client_project_audit.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Review detailed audits of government projects in Quezon City, ensuring transparency and accountability."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="/QTrace-Website/assets/image/QTraceLogo.png">
    <title>QTrace - Audit</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .audit-row-item {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .audit-row-item:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .project-name {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--primary);
        }

        .audit-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .action-badge {
            display: inline-block;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .action-create {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .action-update {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .action-delete {
            background-color: #ffebee;
            color: #d32f2f;
        }

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-filter {
            background-color: var(--primary);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 6px;
        }

        .btn-filter:hover {
            background-color: #0d1f2d;
            color: white;
        }

        .btn-reset {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            border-radius: 6px;
        }

        .btn-reset:hover {
            background-color: var(--primary);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #9ca3af;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .pagination {
            gap: 5px;
        }

        .pagination-info {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .page-link {
            color: var(--primary);
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .page-link:hover {
            background-color: var(--btn-blue-secondary);
            color: var(--primary);
        }

        .page-link.active {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, #0F1D3D 100%);
            color: white;
            padding: 3rem 0;
            border-bottom: 3px solid var(--accent);
        }

        .btn-view-changes {
            background-color: var(--secondary);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-view-changes:hover {
            background-color: #B01F24;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(217, 38, 46, 0.3);
        }

        @media (max-width: 768px) {
            .audit-info {
                grid-template-columns: 1fr;
            }
        }
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
  </head>
    <body class="bg-color-background">

        <!-- Include Navigation -->
        <?php
            include('../../components/topNavigation.php');
        ?>

        <main>
            <section class="container py-5">
                <div class="title-section">
                    <h2 class="fw-bold">Project Logs</h2>
                    <p class="text-muted">Official records of all project-related actions in the QTrace system.</p>
                </div>

        <!-- Main Content -->
            <div class="container">
                <!-- Filter Section -->
                <div class="card border-0 shadow-sm mb-3 p-4">
                    <form method="GET" class="row g-3">
                        <div class="col-lg-5">
                            <label for="searchInput" class="form-label fw-600 text-muted">Search Project</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-start-0" id="searchInput" name="search" placeholder="Search by project name..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="actionFilter" class="form-label fw-600 text-muted">Action Type</label>
                            <select class="form-select" id="actionFilter" name="action">
                                <option value="">All Actions</option>
                                <option value="CREATE" <?php echo ($_GET['action'] ?? '') === 'CREATE' ? 'selected' : ''; ?>>Created</option>
                                <option value="UPDATE" <?php echo ($_GET['action'] ?? '') === 'UPDATE' ? 'selected' : ''; ?>>Updated</option>
                                <option value="DELETE" <?php echo ($_GET['action'] ?? '') === 'DELETE' ? 'selected' : ''; ?>>Deleted</option>
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex align-items-end gap-2">
                            <button class="btn text-light flex-grow-1 bg-color-primary" type="submit">
                                <i class="bi bi-funnel me-2"></i>Apply Filters
                            </button>
                            <a href="?" class="btn btn-secondary flex-grow-1">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Audit Records Section -->
                <?php if ($result && $result->num_rows > 0): ?>

                    <?php while($row = $result->fetch_assoc()): 
                        $projectInfo = getProjectInfo($row['new_values']) ?? getProjectInfo($row['old_values']);
                        $projectTitle = $projectInfo['Project_Title'] ?? 'Unknown Project';
                        $projectBudget = $projectInfo['Project_Budget'] ?? 'N/A';
                        $projectStatus = $projectInfo['Project_Status'] ?? 'N/A';
                        $actionType = $row['action'];
                        $userName = htmlspecialchars($row['user_firstName'] . ' ' . ($row['user_lastName'] ?? ''));
                        $timestamp = formatDate($row['created_at']);
                    ?>
                        <div class="card shadow-sm border mb-3 audit-row-item" onclick="showComparison(<?php echo htmlspecialchars(json_encode($row)); ?>)" data-bs-toggle="modal" data-bs-target="#comparisonModal" style="cursor: pointer; transition: all 0.3s ease;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class=" mb-2 fw-semibold">
                                            <i class="bi bi-briefcase me-2"></i><?php echo htmlspecialchars($projectTitle); ?>
                                        </h6>
                                        <div class="d-flex align-items-center text-muted small">
                                            <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem; color: var(--secondary);"></i>
                                            <span><span class="fw-bold mb-0 text-dark ">Status:</span> <?php echo htmlspecialchars($projectStatus); ?></span>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill action-badge action-<?php echo strtolower($actionType); ?>">
                                        <i class="bi bi-tag me-1"></i><?php echo ucfirst(strtolower($actionType)); ?>
                                    </span>
                                </div>

                                <div class="row g-3 small text-muted">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <i class="bi bi-person-circle text-primary me-2"></i>
                                        <span><span class="fw-semibold text-dark">By:</span> <?php echo $userName; ?></span>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <i class="bi bi-calendar-event text-primary me-2"></i>
                                        <span><span class="fw-semibold text-dark">Date:</span> <?php echo $timestamp; ?></span>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <i class="bi bi-cash-coin text-primary me-2"></i>
                                        <span><span class="fw-semibold text-dark">Budget:</span> <?php echo is_numeric($projectBudget) ? '₱' . number_format($projectBudget, 0) : $projectBudget; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <div class="display-1 mb-3">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5>No audit records found</h5>
                        <p>Try adjusting your search or filter criteria</p>
                    </div>
                <?php endif; ?>

                <!-- Pagination Section -->
                <?php if ($total_pages > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-5 flex-wrap gap-3">
                    <!-- Results Info -->
                    <div class="text-muted small d-flex align-items-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Showing <?= $start_from + 1 ?> to <?= min($start_from + $results_per_page, $total_records) ?> of <?= $total_records ?> projects
                    </div>

                    <!-- Pagination Controls -->
                    <nav aria-label="Project pagination">
                        <ul class="pagination mb-0">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page > 1) ? "?page=".($page - 1)."&search=".urlencode($search)."&action=".$actionFilter : '#' ?>" aria-label="Previous">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php
                            // Smart pagination - show first, last, current and nearby pages
                            $range = 2; // Number of pages to show on each side of current page
                            
                            // Always show first page
                            if ($page > $range + 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&action='.$actionFilter.'">1</a></li>';
                                if ($page > $range + 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            // Show pages around current page
                            for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
                                $active_class = ($page == $i) ? 'active' : '';
                                echo '<li class="page-item '.$active_class.'">
                                        <a class="page-link" href="?page='.$i.'&search='.urlencode($search).'&action='.$actionFilter.'">'.$i.'</a>
                                      </li>';
                            }

                            // Always show last page
                            if ($page < $total_pages - $range) {
                                if ($page < $total_pages - $range - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'&search='.urlencode($search).'&action='.$actionFilter.'">'.$total_pages.'</a></li>';
                            }
                            ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($page < $total_pages) ? "?page=".($page + 1)."&search=".urlencode($search)."&action=".$actionFilter : '#' ?>" aria-label="Next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <!-- Footer -->
        <?php include('../../components/footer.php'); ?>
    </div>

    <!-- Comparison Modal -->
    <div class="modal fade" id="comparisonModal" tabindex="-1" aria-labelledby="comparisonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-color-primary text-white">
                    <h5 class="modal-title" id="comparisonModalLabel">
                        <i class="bi bi-arrow-left-right me-2"></i>Project Change Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #f9fafb;">
                    <div id="comparisonContent">
                        <!-- Content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showComparison(auditData) {
            const oldValues = auditData.old_values ? JSON.parse(auditData.old_values) : null;
            const newValues = auditData.new_values ? JSON.parse(auditData.new_values) : null;
            const action = auditData.action;
            
            let comparisonHTML = '';
            
            // Get all field names
            const allFields = new Set();
            if (oldValues) Object.keys(oldValues).forEach(key => allFields.add(key));
            if (newValues) Object.keys(newValues).forEach(key => allFields.add(key));
            
            // Generate comparison for each field
            allFields.forEach(field => {
                const oldValue = oldValues ? oldValues[field] : null;
                const newValue = newValues ? newValues[field] : null;
                
                let displayOldValue = formatValue(oldValue);
                let displayNewValue = formatValue(newValue);
                
                if (action === 'CREATE') {
                    // For create actions, only show new values
                    comparisonHTML += `
                        <div style="background: white; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; border-left: 4px solid #388e3c;">
                            <div style="font-weight: 600; color: var(--primary); margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.9rem;">${field}</div>
                            <div style="background-color: #e8f5e9; padding: 0.75rem; border-radius: 6px;">
                                <div style="font-weight: 600; color: #388e3c; font-size: 0.8rem; margin-bottom: 0.5rem;">
                                    <i class="bi bi-plus-circle me-1"></i>Created
                                </div>
                                <div>${displayNewValue || '<em>Not specified</em>'}</div>
                            </div>
                        </div>
                    `;
                } else if (action === 'DELETE') {
                    // For delete actions, only show old values
                    comparisonHTML += `
                        <div style="background: white; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; border-left: 4px solid #d32f2f;">
                            <div style="font-weight: 600; color: var(--primary); margin-bottom: 0.5rem; text-transform: uppercase; font-size: 0.9rem;">${field}</div>
                            <div style="background-color: #ffebee; padding: 0.75rem; border-radius: 6px;">
                                <div style="font-weight: 600; color: #d32f2f; font-size: 0.8rem; margin-bottom: 0.5rem;">
                                    <i class="bi bi-trash me-1"></i>Deleted
                                </div>
                                <div>${displayOldValue || '<em>Not specified</em>'}</div>
                            </div>
                        </div>
                    `;
                } else if (action === 'UPDATE') {
                    // For update actions, show before and after
                    if (oldValue !== newValue) {
                        comparisonHTML += `
                            <div style="background: white; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                                <div style="font-weight: 600; color: var(--primary); margin-bottom: 1rem; text-transform: uppercase; font-size: 0.9rem;">${field}</div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                    <div style="background-color: #ffebee; padding: 0.75rem; border-radius: 6px; border-left: 4px solid #d32f2f;">
                                        <div style="font-weight: 600; color: #d32f2f; font-size: 0.8rem; margin-bottom: 0.5rem;">
                                            <i class="bi bi-x-circle me-1"></i>Before
                                        </div>
                                        <div>${displayOldValue || '<em>Not specified</em>'}</div>
                                    </div>
                                    <div style="background-color: #e8f5e9; padding: 0.75rem; border-radius: 6px; border-left: 4px solid #388e3c;">
                                        <div style="font-weight: 600; color: #388e3c; font-size: 0.8rem; margin-bottom: 0.5rem;">
                                            <i class="bi bi-check-circle me-1"></i>After
                                        </div>
                                        <div>${displayNewValue || '<em>Not specified</em>'}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            });
            
            document.getElementById('comparisonContent').innerHTML = comparisonHTML || '<p class="text-muted">No changes to display.</p>';
        }
        
        function formatValue(value) {
            if (value === null || value === undefined) return '';
            if (typeof value === 'object') {
                return JSON.stringify(value, null, 2);
            }
            if (typeof value === 'number') {
                // Try to format as currency if it looks like a budget
                if (value > 1000000) {
                    return '₱' + value.toLocaleString('en-US', {maximumFractionDigits: 2});
                }
                return value.toLocaleString('en-US');
            }
            return String(value);
        }
    </script>
  </body>
</html>
