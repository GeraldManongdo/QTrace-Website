<?php 
    $current_page = 'accountList'; 
    // This controller should now fetch from the 'users' table
    require('../../database/controllers/get_users.php');
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
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="/QTrace-Website/pages/admin/view_account.php?id=<?= $row['user_ID'] ?>" class="btn btn-sm btn-outline-primary" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $row['user_ID'] ?>)" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="bi bi-person-exclamation display-4"></i>
                                                <p class="mt-2">No accounts found in the database.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>



        <!-- Custome Script For This Page Only  --> 
    <script>
        function confirmDelete(id) {
            if(confirm("Are you sure you want to delete this account?")) {
                window.location.href = "../../database/controllers/delete_user.php?id=" + id;
            }
        }
    </script>
    <!-- Reusable Script -->
    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>