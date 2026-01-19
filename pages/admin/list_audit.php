<?php 
    $page_name = 'audit'; 
    require('../../database/controllers/get_admin_audit_list.php');
    include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="List of all audit logs in the QTrace system."/>
    <meta name="author" content="Confractus" />
    <title>QTrace - Audit Logs</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
  </head>
  <body>
    <div class="app-container">
        <?php include('../../components/header.php'); ?>

        <div class="content-area">
            <?php include('../../components/sideNavigation.php'); ?>

            <main class="main-view">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Audit Logs</li>
                        </ol>
                    </nav>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h2 class="fw-bold">Audit Logs</h2>
                            <p class="text-muted">Official list of all audit logs in the QTrace system</p>
                        </div>
                    </div>
                    <!-- Filters Section -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-lg-6">
                                    <label for="searchInput" class="form-label fw-bold text-muted">Search</label>
                                    <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by User..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label for="statusFilter" class="form-label fw-bold text-muted">Status</label>
                                    <select class="form-select" id="statusFilter" name="action">
                                        <option value="">All Status</option>
                                        <option value="EDIT" <?php echo ($_GET['action'] ?? '') === 'EDIT' ? 'selected' : ''; ?>>Edit</option>
                                        <option value="UPDATE" <?php echo ($_GET['action'] ?? '') === 'UPDATE' ? 'selected' : ''; ?>>Update</option>
                                        <option value="CREATE" <?php echo ($_GET['action'] ?? '') === 'CREATE' ? 'selected' : ''; ?>>Create</option>
                                        <option value="ADD" <?php echo ($_GET['action'] ?? '') === 'ADD' ? 'selected' : ''; ?>>Add</option>
                                        <option value="DELETE" <?php echo ($_GET['action'] ?? '') === 'DELETE' ? 'selected' : ''; ?>>Delete</option>
                                        <option value="DEACTIVATE" <?php echo ($_GET['action'] ?? '') === 'DEACTIVATE' ? 'selected' : ''; ?>>Deactivate</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 d-flex align-items-end gap-2">
                                    <div class="col-6">
                                        <button class="btn bg-color-primary text-light fw-medium w-100" type="submit">Apply</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" onclick="window.location.href='?page=1'" class="btn btn-outline-secondary w-100 fw-medium">Reset</button>
                                    </div>
                                        
                                </div>

                            </form>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Performed By</th>
                                        <th>Action</th>
                                        <th>Target Resource</th>
                                        <th>ID</th>
                                        <th class="text-center">Compare</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <?php if (empty($audit_logs)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">No audit activities found in the database.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($audit_logs as $log): ?>
                                            <tr>
                                                <td class="small">
                                                    <?php echo date('M d, Y', strtotime($log['created_at'])); ?><br>
                                                    <span class="text-muted"><?php echo date('h:i A', strtotime($log['created_at'])); ?></span>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">
                                                        <?php echo htmlspecialchars($log['user_firstName'] . ' ' . $log['user_lastName'] ?? 'System / Auto'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $statusClass = 'bg-secondary';
                                                        if($log['action'] == 'EDIT' || $log['action'] == 'UPDATE') $statusClass = 'bg-primary';
                                                        if($log['action'] == 'CREATE' || $log['action'] == 'ADD') $statusClass = 'bg-success';
                                                        if($log['action'] == 'DELETE' || $log['action'] == 'DEACTIVATE') $statusClass = 'bg-danger';
                                                    ?>
                                                    <span class="badge rounded-pill <?= $statusClass ?>">
                                                        <?= htmlspecialchars($log['action']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-uppercase" style="font-size: 0.85rem;">
                                                        <?php echo htmlspecialchars($log['resource_type']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <code class="text-dark">#<?php echo htmlspecialchars($log['resource_id']); ?></code>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-primary" 
                                                                onclick='viewDiff(<?php echo json_encode($log['old_values']); ?>, <?php echo json_encode($log['new_values']); ?>)'>
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if (isset($pagination) && $pagination['total_pages'] > 0): ?>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        Showing 
                                        <span id="recordStart"><?php echo (($pagination['current_page'] - 1) * $pagination['per_page']) + 1; ?></span> 
                                        to 
                                        <span id="recordEnd"><?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']); ?></span> 
                                        of 
                                        <span id="totalRecords"><?php echo $pagination['total_records']; ?></span> 
                                        audit logs
                                    </small>
                                </div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <li class="page-item <?php echo $pagination['current_page'] === 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>&action=<?php echo urlencode($_GET['action'] ?? ''); ?>">Previous</a>
                                        </li>
                                        <li class="page-item"><span class="page-link"><?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></span></li>
                                        <li class="page-item <?php echo $pagination['current_page'] === $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>&action=<?php echo urlencode($_GET['action'] ?? ''); ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <?php endif; ?>
                        </div>
                    </div>

                    <div class="modal fade" id="detailModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"><h5>Change Details</h5></div>
                                <div class="modal-body">
                                    <h6>Before:</h6>
                                    <pre id="oldVal" class="bg-light p-2 border"></pre>
                                    <h6>After:</h6>
                                    <pre id="newVal" class="bg-light p-2 border text-success"></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
    <div class="modal fade" id="diffModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Change Comparison</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <p class="fw-bold text-danger">OLD VALUES (Before)</p>
                        <pre id="oldJson" class="p-2 bg-light border small" style="max-height: 400px; overflow: auto;"></pre>
                    </div>
                    <div class="col-md-6">
                        <p class="fw-bold text-success">NEW VALUES (After)</p>
                        <pre id="newJson" class="p-2 bg-light border small" style="max-height: 400px; overflow: auto;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

    <?php include('../../components/toast.php'); ?>



    <!-- Custome Script For This Page Only  --> 
    <script>
function viewDiff(oldVal, newVal) {
    const modal = new bootstrap.Modal(document.getElementById('diffModal'));
    
    // Parse and beautify the JSON
    const formatJSON = (val) => {
        if (!val) return "No data available";
        try {
            // Check if it's already an object or needs parsing
            const obj = typeof val === 'string' ? JSON.parse(val) : val;
            return JSON.stringify(obj, null, 4);
        } catch (e) { return val; }
    };

    document.getElementById('oldJson').textContent = formatJSON(oldVal);
    document.getElementById('newJson').textContent = formatJSON(newVal);
    
    modal.show();
}
</script>
    <!-- Reusable Script -->
    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="/QTrace-Website/assets/js/toast.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  </body>
</html>