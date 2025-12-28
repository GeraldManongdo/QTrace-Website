<?php $current_page = 'addProject'; ?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="QTrace is the official Quezon City Transparency Platform, enabling citizens to track government projects, monitor progress, and report issues for greater accountability.">
        <meta name="author" content="Confractus">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
        <title>QTrace - Quezon City Transparency Platform</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>
    <body>
        
        <div class="d-lg-none p-3 bg-dark text-white">
            <button class="btn btn-dark border" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>

        <div class="container-fluid">
            <div class="row">
                
                <?php
                    include('../../components/sideNavigation.php');
                ?>

                <main class="main-content col p-4">
                    <h2>Content Area</h2>
                    <p>On large screens, the sidebar is fixed. On mobile, click the toggle button to see the offcanvas menu.</p>
                </main>

            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>