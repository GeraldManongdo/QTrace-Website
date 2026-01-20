<?php 
    $page_name = 'reports';
    include('../../database/connection/security.php');
    require('../../database/controllers/get_all_reports.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Manage and view all reports in the system"/>
        <meta name="author" content="Confractus" />
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Report List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
        <style>
            .status-badge {
                padding: 4px 14px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 500;
            }
            .table thead th,
            .table tbody td {
                padding-inline: 1rem; 
            }
            .status-open {
                background-color: var(--primary);
                color: white;
            }
            .status-in-progress {
                background-color: var(--accent);
                color: white;
            }
            .status-resolved {
                background-color: var(--secondary);
                color: white;
            }
            .evidence-link {
                color: var(--primary);
                text-decoration: none;
                font-size: 0.9rem;
            }
            .evidence-link:hover {
                text-decoration: underline;
            }
            .action-btn {
                width: 32px;
                height: 32px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <div class="app-container">
            <?php include('../../components/header.php'); ?>

            <div class="content-area">
                <?php include('../../components/sideNavigation.php'); ?>

                <main class="main-view">
                    <div class="container-fluid px-4">
                        <nav aria-label="breadcrumb">
                            <!-- Breadcrumb -->
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/QTrace-Website/dashboard">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Report List</li>
                            </ol>
                        </nav>

                        <div class="row mb-2">
                            <div class="col">
                                <!-- Page Header -->
                                <h2 class="fw-bold">Report List</h2>
                                <p>Manage and view all reports in the system</p>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="row g-3">
                                    <div class="col-lg-4">
                                        <label for="searchInput" class="form-label fw-bold text-muted">Search</label>
                                        <input type="text" class="form-control" id="searchInput" name="search" 
                                               placeholder="Search by title or description..." 
                                               value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="statusFilter" class="form-label fw-bold text-muted">Status</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">All Status</option>
                                            <option value="open" <?php echo ($_GET['status'] ?? '') === 'open' ? 'selected' : ''; ?>>Open</option>
                                            <option value="in progress" <?php echo ($_GET['status'] ?? '') === 'in progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="resolved" <?php echo ($_GET['status'] ?? '') === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="typeFilter" class="form-label fw-bold text-muted">Type</label>
                                        <select class="form-select" id="typeFilter" name="type">
                                            <option value="">All Types</option>
                                            <?php foreach($reportTypes as $reportType): ?>
                                                <option value="<?php echo htmlspecialchars($reportType); ?>" 
                                                    <?php echo ($_GET['type'] ?? '') === $reportType ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($reportType); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 d-flex align-items-end gap-2">
                                        <div class="col-6">
                                            <button class="btn bg-color-primary text-light fw-medium w-100" type="submit">Apply</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-secondary w-100 fw-medium" onclick="resetFilters()">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Reports Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 8%;">Report ID</th>
                                            <th style="width: 20%;">Project Name</th>
                                            <th class="d-none d-md-table-cell" style="width: 10%;">User Name</th>
                                            <th class="text-center" style="width: 10%;">Status</th>
                                            <th class="d-none d-md-table-cell" style="width: 12%;">Type</th>
                                            
                                            
                                            <th style="width: 10%;">Created Date</th>
                                            <th class="text-center" style="width: 5%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0): ?>
                                            <?php while($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <span class="fw-bold">RPT-<?php echo str_pad($row['report_ID'], 3, '0', STR_PAD_LEFT); ?></span>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($row['ProjectDetails_Title']); ?>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?>
                                                </td>
                                                <td class="text-center">
                                                        <?php echo $row['report_status']; ?>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span class="text-dark"><?php echo htmlspecialchars($row['report_type'] ?? 'N/A'); ?></span>
                                                </td>
                                                
                                                <td>
                                                    <?php echo date('M d, Y', strtotime($row['report_CreatedAt'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="/QTrace-Website/view-report?id=<?php echo $row['report_ID']; ?>" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="View Report">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <p class="mt-3 mb-0">No reports found matching your criteria.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <?php if (!empty($pagination) && $pagination['total_pages'] > 0): ?>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="text-muted">
                                    Showing 
                                    <span id="recordStart"><?php echo (($pagination['current_page'] - 1) * $pagination['per_page']) + 1; ?></span> 
                                    to 
                                    <span id="recordEnd"><?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']); ?></span> 
                                    of 
                                    <span id="totalRecords"><?php echo $pagination['total_records']; ?></span> 
                                    reports
                                </small>
                            </div>
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item <?php echo $pagination['current_page'] === 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&type=<?php echo urlencode($_GET['type'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Previous</a>
                                    </li>
                                    <li class="page-item"><span class="page-link"><?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></span></li>
                                    <li class="page-item <?php echo $pagination['current_page'] === $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&type=<?php echo urlencode($_GET['type'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>

                    </div>
                </main>
            </div>
        </div>

        <!-- Chat Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Report Chat History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="chatModalBody">
                        <div class="text-center py-5">
                            <div class="spinner-border" style="color: var(--primary);" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
        function resetFilters() {
            window.location.href = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>';
        }
        </script>

        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
                crossorigin="anonymous"></script>
    </body>
</html>
