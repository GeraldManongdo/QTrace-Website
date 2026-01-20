<?php 
    $page_name = 'accountList';
    require('../../database/connection/connection.php');

    // 1. Get ID from URL and protect against basic injection
    $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($user_id > 0) {
        // 2. Fetch User Data
        $stmt = $conn->prepare("SELECT * FROM user_table WHERE user_ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            die("User not found.");
        }

        // 3. Logic for Age Calculation
        $birthDate = new DateTime($user['user_birthDate']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } else {
        header("Location: account_list.php");
        exit();
    }
    
    include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Official details of a user account in the QTrace system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Account Details</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .profile-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 40px 0; }
        .company-logo-lg { width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .doc-card:hover { background-color: #f1f8ff; transition: 0.3s; }

        .main-card { border-radius: 12px; border: none; }
        .status-pill { border-radius: 50px; padding: 4px 12px; font-size: 0.85rem; font-weight: 500; }
        .icon-box { width: 40px; height: 40px; background: #eef2ff; color: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    </style>

  </head>
  <body>
    <div class="app-container">
        
        <?php
            // Header Include
            include('../../components/header.php');
        ?>

        <div class="content-area">
            <?php
                // Sidebar Include
                include('../../components/sideNavigation.php');
            ?>

            <main class="main-view">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <!-- Breadcrumb -->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"> <a href="/QTrace-Website/dashboard">Home</a> </li>
                            <li class="breadcrumb-item"><a href="/QTrace-Website/account-list">Account List</a></li>
                            <li class="breadcrumb-item active">Account Details</li>
                        </ol>
                    </nav>

                    <div class="row mb-2 p-2 align-items-center">
                        <div class="col">
                            <!-- Page Header -->
                             <h2 class="fw-bold">Account Details</h2>
                            <p>Official details of a user account in the QTrace system</p>
                        </div>
                    </div>
                    
                    <div class="row g-2">
                        <div class="card border-0 shadow-sm mb-2 p-3">
                            <div class="card-body mb-3">
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                    
                                    <!-- Logo -->
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3" style="width: 70px; height: 70px; font-size: 28px; font-weight: bold;">
                                        <?= strtoupper(substr($user['user_firstName'], 0, 1) . substr($user['user_lastName'], 0, 1)) ?>
                                    </div>
                                    

                                    <div class="flex-grow-1">
                                        <h1 class="fw-medium mb-1 fs-3"><?= htmlspecialchars($user['user_firstName'] . ' ' . $user['user_lastName']) ?></h1>
                                        <p class="text-muted mb-0 fs-6"><i class="bi bi-person-badge me-2"></i><?= htmlspecialchars($user['user_Role']) ?></p>
                                    </div>
                                    
                                    <!-- Edit Button -->
                                    <div class="mt-3 mt-md-0 ms-md-3 d-flex justify-content-start justify-content-md-end">
                                        <a href="/QTrace-Website/edit-account?id=<?= $user['user_ID'] ?>" class="btn btn-blue-primary btn-dark px-3 py-2 text-nowrap">
                                            Edit Profile
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 main-card mb-4 ">
                                <div class="container row g-5">
                                    <!-- Personal Information-->
                                    <div class="col-md-6 border-end pe-md-4">
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Personal Details</h6>
                                        <hr class="border-top">
                                        
                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">QC ID Number</label>
                                            <span class="fw-semibold text-primary"><?= htmlspecialchars($user['QC_ID_Number']) ?></span>
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">Sex / Gender</label>
                                            <span class="fw-semibold"><?= ucfirst($user['user_sex']) ?></span>
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">Birthdate</label>
                                            <span class="fw-semibold"><?= date("F d, Y", strtotime($user['user_birthDate'])) ?></span>
                                            <span class="text-muted small ms-2">(<?= $age ?> years old)</span>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="col-md-6 ps-md-4">
                                        <h6 class="text-uppercase text-muted small fw-bold mb-2">Contact Information</h6>
                                        <hr class="border-top">

                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">Email Address</label>
                                            <span class="fw-semibold"><?= htmlspecialchars($user['user_Email']) ?></span>
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">Phone Number</label>
                                            <span class="fw-semibold"><?= htmlspecialchars($user['user_contactInformation']) ?></span>
                                        </div>

                                        <div class="mb-4">
                                            <label class="text-muted d-block small mb-1">Home Address</label>
                                            <span class="fw-semibold"><?= nl2br(htmlspecialchars($user['user_address'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if ($_SESSION['user_ID'] == $user['user_ID']): ?>
                                        <button type="button" class="btn btn-outline-secondary btn-sm w-100 p-2 disabled" title="You cannot disable your own account">
                                            <i class="bi bi-shield-lock me-2"></i> Current Account
                                        </button>

                                    <?php elseif ($user['user_status'] == 'active'): ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 p-2" onclick="confirmDisable(<?= $user['user_ID'] ?>)" title="Disable Account">
                                            <i class="bi bi-person-x me-2"></i> Disable Account
                                        </button>

                                    <?php else: ?>
                                        <button type="button" class="btn btn-outline-success btn-sm w-100 p-2" onclick="confirmActive(<?= $user['user_ID'] ?>)" title="Activate Account">
                                            <i class="bi bi-person-check me-2"></i> Activate Account
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                </div>
            </div>
        </main>
    </div>

    <?php include('../../components/toast.php'); ?>

    <!-- Custome Script For This Page Only  --> 
    <script>
        // Handles Disabling
        function confirmDisable(id) {
            if(confirm("Are you sure you want to disable this account? The user will no longer be able to log in.")) {
                window.location.href = "/QTrace-Website/database/controllers/disable_account.php?id=" + id;
            }
        }

        // Handles Activating
        function confirmActive(id) {
            if(confirm("Are you sure you want to reactivate this account?")) {
                // Adjust this path to your actual activation controller
                window.location.href = "/QTrace-Website/database/controllers/activate_account.php?id=" + id;
            }
        }
    </script>
        
    <!-- Reusable Script -->
    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="/QTrace-Website/assets/js/toast.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
