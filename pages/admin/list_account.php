<?php 
    $page_name = 'accountList'; 
    require('../../database/controllers/get_admin_users_list.php');
    include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="List of all user accounts in the QTrace system."/>
    <meta name="author" content="Confractus" />
    <title>QTrace - Account List</title>
    
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
                            <li class="breadcrumb-item active">Account List</li>
                        </ol>
                    </nav>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h2 class="fw-bold">Account List</h2>
                            <p class="text-muted">Official list of all user accounts in the QTrace system</p>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-lg-9">
                                    <label class="form-label fw-bold text-muted">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="e.g. Given Name, Last Name, QcID" value="<?= htmlspecialchars($search) ?>">
                                </div>
                                <div class="col-lg-3 d-flex align-items-end row g-2">
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
                                        <th>QcID</th>
                                        <th>Full Name</th>
                                        <th>Role</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($result) && $result->num_rows > 0): ?>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= str_pad($row['QC_ID_Number'], 5, '0', STR_PAD_LEFT) ?></td>
                                            <td>
                                                <?= htmlspecialchars($row['user_firstName'] . ' ' .  $row['user_middleName'].' ' . $row['user_lastName']) ?>
                                            </td>
                                            <td>
                                                <span class="badge <?= $row['user_Role'] == 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                                    <?= ucfirst($row['user_Role']) ?>
                                                </span>
                                            </td>
                                            <td><?= ucfirst($row['user_sex']) ?></td>
                                            <td>
                                                <?php 
                                                    $birthDate = new DateTime($row['user_birthDate']); 
                                                    $today = new DateTime();
                                                    $age = $today->diff($birthDate)->y; 
                                                    echo $age . "";
                                                ?>
                                            </td>
                                            <td >
                                                <span class="badge <?= $row['user_status'] == 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= ucfirst($row['user_status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="/QTrace-Website/view-account?id=<?= $row['user_ID'] ?>" class="btn btn-sm btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm" onclick="confirmDisable(<?= $row['user_ID'] ?>)" title="Disable" style="background-color: transparent; border: 1px solid #c2180c; color: #c2180c;" onmouseover="this.style.backgroundColor='#871810'; this.style.borderColor='#871810'; this.style.color='#ffffff'; this.querySelector('i').style.color='#ffffff';" onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#c2180c'; this.style.color='#c2180c'; this.querySelector('i').style.color='#c2180c';">
                                                        <i class="bi bi-x-circle" style="color:#c2180c;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="12" class="text-center py-5 text-muted">
                                                <p class="mt-2">No accounts found in the database.</p>
                                            </td>
                                        </tr>
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
                                        accounts
                                    </small>
                                </div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <li class="page-item <?php echo $pagination['current_page'] === 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Previous</a>
                                        </li>
                                        <li class="page-item"><span class="page-link"><?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></span></li>
                                        <li class="page-item <?php echo $pagination['current_page'] === $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include('../../components/toast.php'); ?>



        <!-- Custome Script For This Page Only  --> 
    <script>
        function confirmDisable(id) {
            if(confirm("Are you sure you want to disable this account? The user will no longer be able to log in.")) {
                window.location.href = "/QTrace-Website/database/controllers/disable_account.php?id=" + id;
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