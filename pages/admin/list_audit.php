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
    <link rel="icon" type="image/png" sizes="16x16" href="/QTrace-Website/assets/image/QTraceLogo.png">
    <title>QTrace - Audit Logs</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
  </head>
  <style>
        .pagination .page-link {
                color: #003366;
            }
        .pagination a.page-link:hover {
                background-color: #003366;
                color: white;
                border-color: #003366;
            }
    </style>
  <body>
    <div class="app-container">
        <?php include('../../components/header.php'); ?>

        <div class="content-area">
            <?php include('../../components/sideNavigation.php'); ?>

            <main class="main-view">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Dashboard</a></li>
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
                                        <th>Audit ID</th>
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
                                                <td class="fw-bold"><?php echo $log['audit_log_id']; ?></td>
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
                                                    <span class="badge <?= $statusClass ?>">
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
                                                                onclick="showComparison(<?php echo htmlspecialchars(json_encode($log)); ?>)" 
                                                                data-bs-toggle="modal" data-bs-target="#comparisonModal">
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
                    </div>
                    
                    <!-- Pagination Section -->
                    <?php if (isset($pagination) && $pagination['total_pages'] > 0): ?>
                            <div class="d-flex justify-content-between align-items-center mt-4">
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
                        <?php endif; ?>

                </div>
            </main>
        </div>
    </div>
    <!-- Comparison Modal -->
    <div class="modal fade" id="comparisonModal" tabindex="-1" aria-labelledby="comparisonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-color-primary text-white">
                    <h5 class="modal-title" id="comparisonModalLabel">
                        <i class="bi bi-arrow-left-right me-2"></i>Audit Change Details
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

    <?php include('../../components/toast.php'); ?>



    <!-- Custome Script For This Page Only  --> 
    <script>
function showComparison(auditData) {
    const oldValues = auditData.old_values ? JSON.parse(auditData.old_values) : null;
    const newValues = auditData.new_values ? JSON.parse(auditData.new_values) : null;
    const action = auditData.action;
    
    let comparisonHTML = '';
    
    const allFields = new Set();
    if (oldValues) Object.keys(oldValues).forEach(key => allFields.add(key));
    if (newValues) Object.keys(newValues).forEach(key => allFields.add(key));
    
    allFields.forEach(field => {
        const oldValue = oldValues ? oldValues[field] : null;
        const newValue = newValues ? newValues[field] : null;
        
        let displayOldValue = formatValue(oldValue);
        let displayNewValue = formatValue(newValue);
        
        if (action === 'CREATE') {
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
        } else if (action === 'DELETE' || action === 'DEACTIVATE') {
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
        } else if (action === 'UPDATE' || action === 'EDIT') {
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
        if (value > 1000000) {
            return '₱' + value.toLocaleString('en-US', {maximumFractionDigits: 2});
        }
        return value.toLocaleString('en-US');
    }
    return String(value);
}

function confirmUndo(auditId, resourceType, action) {
    const message = `Are you sure you want to undo this ${action} action on ${resourceType}? This will restore the old values.`;
    if (confirm(message)) {
        console.log('Submitting undo for audit ID:', auditId);
        
        // Create form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/QTrace-Website/database/controllers/undo_audit_action.php';
        form.style.display = 'none';
        
        // Create input
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'audit_id';
        input.value = auditId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        
        console.log('Form created, submitting...');
        form.submit();
    }
}
</script>
    <!-- Reusable Script -->
    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="/QTrace-Website/assets/js/toast.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  </body>
</html>