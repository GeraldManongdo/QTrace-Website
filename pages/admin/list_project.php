<?php 
    $page_name = 'projectList';

    include('../../database/connection/security.php');
    require('../../database/controllers/get_admin_project_list.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="List of projects on Quezon City government projects."/>
        <meta name="author" content="Confractus" />
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Project List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
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
                                <!-- Breadcrumb -->
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                    <a href="/QTrace-Website/dashboard">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Project List</li>
                                </ol>
                            </nav>

                        <div class="row mb-4">
                            <div class="col">
                                <h2 class="fw-bold">Project List</h2>
                                <p>Manage and view all projects in the system</p>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <form method="GET" class="row g-3">
                                   <div class="col-lg-4">
                                        <label for="searchInput" class="form-label fw-bold text-muted">Search</label>
                                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by title or description..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="statusFilter" class="form-label fw-bold text-muted">Status</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">All Status</option>
                                            <option value="Planning" <?php echo ($_GET['status'] ?? '') === 'Planning' ? 'selected' : ''; ?>>Planning</option>
                                            <option value="Ongoing" <?php echo ($_GET['status'] ?? '') === 'Ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                                            <option value="Completed" <?php echo ($_GET['status'] ?? '') === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="Delayed" <?php echo ($_GET['status'] ?? '') === 'Delayed' ? 'selected' : ''; ?>>Delayed</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="contractorFilter" class="form-label fw-bold text-muted">Contractor</label>
                                        <select class="form-select" id="contractorFilter" name="contractor_id">
                                            <option value="">All Contractors</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 d-flex align-items-end gap-2">
                                        <div class="col-6">
                                            <button class="btn bg-color-primary text-light fw-medium w-100" type="submit">Apply</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="?page=1" class="btn btn-outline-secondary w-100 fw-medium">Reset</button>
                                        </div>
                                            
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- Engineer List Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 35%;">Project Title</th>
                                            <th>Status</th>
                                            <th>Budget</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0): ?>
                                            <?php while($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['ProjectDetails_Title']) ?></div>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 300px;">
                                                        <?= htmlspecialchars($row['ProjectDetails_Description']) ?>
                                                    </small>
                                                </td>

                                                <td>
                                                    <?php 
                                                        $statusClass = 'bg-secondary';
                                                        if($row['Project_Status'] == 'Ongoing') $statusClass = 'bg-primary';
                                                        if($row['Project_Status'] == 'Completed') $statusClass = 'bg-success';
                                                        if($row['Project_Status'] == 'Delayed') $statusClass = 'bg-danger';
                                                        if($row['Project_Status'] == 'Planning') $statusClass = 'bg-info text-dark';
                                                    ?>
                                                    <span class="badge rounded-pill <?= $statusClass ?>">
                                                        <?= htmlspecialchars($row['Project_Status']) ?>
                                                    </span>
                                                </td>

                                                <td class="fw-bold">
                                                    ₱<?= number_format($row['ProjectDetails_Budget'], 2) ?>
                                                </td>

                                                <td><?= date('M d, Y', strtotime($row['ProjectDetails_StartedDate'])) ?></td>
                                                <td><?= date('M d, Y', strtotime($row['ProjectDetails_EndDate'])) ?></td>

                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="/QTrace-Website/view-project?id=<?= $row['Project_ID'] ?>" class="btn btn-sm btn-outline-primary" title="View Project">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <button class="btn btn-sm" onclick="confirmDisable(<?= $row['Project_ID'] ?>)" title="Disable Project" style="background-color: transparent; border: 1px solid #c2180c; color: #c2180c;" onmouseover="this.style.backgroundColor='#871810'; this.style.borderColor='#871810'; this.style.color='#ffffff'; this.querySelector('i').style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#c2180c'; this.style.color='#c2180c'; this.querySelector('i').style.color='#c2180c';">
                                                            <i class="bi bi-x-circle" style="color:#c2180c;"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">No projects found matching your criteria.</td>
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
                                    projects
                                </small>
                            </div>
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item <?php echo $pagination['current_page'] === 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&contractor_id=<?php echo urlencode($_GET['contractor_id'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Previous</a>
                                    </li>
                                    <li class="page-item"><span class="page-link"><?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></span></li>
                                    <li class="page-item <?php echo $pagination['current_page'] === $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&contractor_id=<?php echo urlencode($_GET['contractor_id'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>

                    </div>
                </main>
            </div>
        </div>
        <?php include('../../components/toast.php'); ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/QTrace-Website/assets/js/toast.js"></script>
        <script>
            function confirmDisable(id) {
                if (confirm('Are you sure you want to disable this project? It will be hidden from public view.')) {
                window.location.href = "/QTrace-Website/database/controllers/disable_project.php?id=" + id;
                }
            }
        </script>
    </body>
</html>