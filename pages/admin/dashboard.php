<?php 
    $page_name = 'dashboard'; 
    include('../../database/connection/security.php');    
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="QTrace is the official Quezon City Transparency Platform, enabling citizens to track government projects, monitor progress, and report issues for greater accountability.">
        <meta name="author" content="Confractus">
        <link rel="icon" type="image/png" sizes="16x16" href="">
        <title>QTrace - Quezon City Transparency Platform</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css">
        <style>
            :root {
            --sidebar-width: 280px;
            --header-height: 65px;
        }
 
        </style>
    </head>
    <body style="background-color: var(--bg-light);">
        <div class="app-container">
            <?php
                include('../../components/header.php');
            ?>
    
            <div class="content-area">
                <?php
                    include('../../components/sideNavigation.php');
                ?>

                <main class="main-view">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h4 fw-bold m-0">Dashboard Overview</h2>
                            <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> New Project</button>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm p-3">
                                    <span class="text-muted small fw-bold text-uppercase">Total Projects</span>
                                    <h3 class="fw-bold m-0 mt-1">128</h3>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm p-4" style="min-height: 1000px;">
                                    <p class="text-muted">The header and sidebar are fixed. Only this area scrolls.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
            
    <!-- Custome Script For This Page Only  --> 
    <script>

    </script>
         
    <!-- Reusable Script -->
     <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
