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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/QTrace-Website/dashboard">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Report List</li>
                            </ol>
                        </nav>

                        <div class="row mb-4">
                            <div class="col">
                                <h2 class="fw-bold">Report List</h2>
                                <p class="text-muted">Manage and view all reports in the system</p>
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
                                            <th style="width: 35%;">Report Description</th>
                                            <th class="text-center" style="width: 10%;">Status</th>
                                            <th class="d-none d-md-table-cell" style="width: 12%;">Type</th>
                                            <th style="width: 10%;">Project ID</th>
                                            <th class="d-none d-md-table-cell" style="width: 10%;">User ID</th>
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
                                                    <div class="text-dark mb-1">
                                                        <?php echo htmlspecialchars(substr($row['report_description'], 0, 120)); ?>
                                                        <?php if(strlen($row['report_description']) > 120) echo '...'; ?>
                                                    </div>
                                                    <?php if(!empty($row['report_evidencesPhoto_URL'])): ?>
                                                        <a href="<?php echo htmlspecialchars($row['report_evidencesPhoto_URL']); ?>" 
                                                           target="_blank" class="evidence-link">
                                                            <i class="bi bi-image me-1"></i>1 evidence photo(s)
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                        $statusClass = 'status-open';
                                                        $statusText = ucfirst($row['report_status']);
                                                        if($row['report_status'] == 'in progress') {
                                                            $statusClass = 'status-in-progress';
                                                            $statusText = 'In Review';
                                                        } elseif($row['report_status'] == 'resolved') {
                                                            $statusClass = 'status-resolved';
                                                            $statusText = 'Resolved';
                                                        } elseif($row['report_status'] == 'open') {
                                                            $statusText = 'Reading';
                                                        }
                                                    ?>
                                                    <span class="status-badge <?php echo $statusClass; ?>">
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span class="text-dark"><?php echo htmlspecialchars($row['report_type'] ?? 'N/A'); ?></span>
                                                </td>
                                                <td>
                                                    <a href="/QTrace-Website/view-project?id=<?php echo $row['Project_ID']; ?>" 
                                                       class="text-decoration-none fw-medium" style="color: var(--primary);">
                                                        PRJ-<?php echo date('Y', strtotime($row['report_CreatedAt'])); ?>-<?php echo str_pad($row['Project_ID'], 3, '0', STR_PAD_LEFT); ?>
                                                    </a>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span class="text-dark fw-medium">USR-<?php echo $row['user_ID']; ?></span>
                                                </td>
                                                <td>
                                                    <?php echo date('M d, Y', strtotime($row['report_CreatedAt'])); ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                                          <a href="/QTrace-Website/pages/admin/view_report.php?id=<?php echo $row['report_ID']; ?>" 
                                                           class="btn btn-sm action-btn" style="border: 1px solid var(--primary); color: var(--primary);" 
                                                           title="View Report">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <button class="btn btn-sm action-btn dropdown-toggle dropdown-toggle-split" style="border: 1px solid var(--surface); color: #6c757d;" 
                                                                type="button" data-bs-toggle="dropdown" title="More actions">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="/QTrace-Website/pages/admin/view_report.php?id=<?php echo $row['report_ID']; ?>">
                                                                    <i class="bi bi-eye me-2"></i>View Details
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" 
                                                                   onclick="openChatModal(<?php echo $row['report_ID']; ?>)">
                                                                    <i class="bi bi-chat-dots me-2"></i>View Chat (<?php echo $row['message_count']; ?>)
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <?php if($row['report_status'] != 'resolved'): ?>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" 
                                                                   onclick="updateStatus(<?php echo $row['report_ID']; ?>, 'in progress')">
                                                                    <i class="bi bi-clock-history me-2"></i>Mark In Progress
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" 
                                                                   onclick="updateStatus(<?php echo $row['report_ID']; ?>, 'resolved')">
                                                                    <i class="bi bi-check-circle me-2"></i>Mark Resolved
                                                                </a>
                                                            </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                                    <p class="mt-3 mb-0">No reports found matching your criteria.</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if ($result && $result->num_rows > 0): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                Showing <?php echo $result->num_rows; ?> report(s)
                            </small>
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
        function updateStatus(reportId, newStatus) {
            if (!confirm(`Are you sure you want to mark this report as "${newStatus}"?`)) {
                return;
            }
            
            const formData = new FormData();
            formData.append('report_id', reportId);
            formData.append('status', newStatus);
            
            fetch('/QTrace-Website/database/controllers/update_report_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Report status updated successfully!');
                    location.reload();
                } else {
                    alert('Failed to update status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating status. Please try again.');
            });
        }

        function openChatModal(reportId) {
            const modal = new bootstrap.Modal(document.getElementById('chatModal'));
            modal.show();
            
            fetch(`/QTrace-Website/database/controllers/get_report_chat.php?report_id=${reportId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayChatHistory(data);
                    } else {
                        document.getElementById('chatModalBody').innerHTML = 
                            '<div class="alert alert-danger">Failed to load chat history</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('chatModalBody').innerHTML = 
                        '<div class="alert alert-danger">Error loading chat history</div>';
                });
        }

        function displayChatHistory(data) {
            const parent = data.parent;
            const messages = data.messages;
            
            let html = `
                <div class="alert alert-primary">
                    <strong>Original Report</strong><br>
                    <small class="text-muted">${parent.username} • ${new Date(parent.report_CreatedAt).toLocaleString()}</small>
                    <p class="mt-2 mb-0">${escapeHtml(parent.report_description)}</p>
                    ${parent.report_evidencesPhoto_URL ? 
                        `<div class="mt-2"><img src="${parent.report_evidencesPhoto_URL}" class="img-thumbnail" style="max-width: 200px;"></div>` 
                        : ''}
                </div>
            `;
            
            if (messages.length > 0) {
                html += '<div class="mt-3"><strong>Chat History:</strong></div>';
                messages.forEach(msg => {
                    const isAdmin = msg.user_role === 'admin';
                    const alertClass = isAdmin ? 'alert-warning' : 'alert-light';
                    html += `
                        <div class="alert ${alertClass} mt-2">
                            <small class="text-muted">
                                ${msg.username}${isAdmin ? ' <span class="badge bg-danger">Admin</span>' : ''} • 
                                ${new Date(msg.report_CreatedAt).toLocaleString()}
                            </small>
                            <p class="mt-1 mb-0">${escapeHtml(msg.report_description)}</p>
                        </div>
                    `;
                });
            } else {
                html += '<div class="alert alert-secondary mt-3">No replies yet</div>';
            }
            
            document.getElementById('chatModalBody').innerHTML = html;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function resetFilters() {
            const url = new URL(window.location.href);
            url.search = '';
            window.location.href = url.toString();
        }
        </script>

        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
                crossorigin="anonymous"></script>
    </body>
</html>
