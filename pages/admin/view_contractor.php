<?php 
    $current_page = 'contractorList'; 
    require('../../database/controllers/get_view_contractor.php');
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
    <meta name="description" content="Details of a verified contractor working on Quezon City government projects."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Contractor Details</title>
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
                            <li class="breadcrumb-item"><a href="/QTrace-Website/contractor-list?id=<?= $contractor_id ?>">Contractor List</a></li>
                            <li class="breadcrumb-item active">Contractor Details</li>
                        </ol>
                    </nav>

                    <div class="row mb-2">
                        <div class="col">
                            <!-- Page Header -->
                             <h2 class="fw-bold">Contractor Details</h2>
                            <p>Official details of a verified contractor working on Quezon City government projects</p>
                        </div>
                    </div>
                    
                    <!-- Filter Form -->
                    <div class="row g-3">
                        <div class="card border-0 shadow-sm mb-2 p-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="<?= !empty($contractor['Contractor_Logo_Path']) ? $contractor['Contractor_Logo_Path'] : 'https://via.placeholder.com/150' ?>" class="company-logo-lg rounded-3 me-4" alt="Company Logo">
                                    <div>
                                        <h1 class="fw-medium mb-1 fs-3"><?= htmlspecialchars($contractor['Contractor_Name']) ?></h1>
                                        <p class="text-muted mb-0 fs-6"><i class="bi bi-person-badge me-2"></i><?= htmlspecialchars($contractor['Owner_Name']) ?></p>
                                        <div class="mt-2">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill"><?= $contractor['Years_Of_Experience'] ?> Years Experience</span>
                                        </div>
                                    </div>
                                    <div class="ms-auto d-flex ">
                                        <a href="edit_contractor.php?id=<?= $contractor_id ?>" class="btn btn-dark">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Engineer List Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Contact Details</h5>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Email Address</label>
                        <span class="fw-medium text-primary"><?= htmlspecialchars($contractor['Company_Email_Address']) ?></span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Contact Number</label>
                        <span class="fw-medium"><?= htmlspecialchars($contractor['Contact_Number']) ?></span>
                    </div>
                    <div>
                        <label class="small text-muted d-block">Business Address</label>
                        <span class="fw-medium"><?= nl2br(htmlspecialchars($contractor['Company_Address'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Skills & Expertise</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php if($expertise_res->num_rows > 0): ?>
                            <?php while($exp = $expertise_res->fetch_assoc()): ?>
                                <span class="badge bg-info text-dark border px-3 py-2">
                                    <?= htmlspecialchars($exp['Expertise']) ?>
                                </span>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted small">No expertise listed.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Legal Documents</h5>
                </div>
                <div class="card-body">
                    <?php if($documents_res->num_rows > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php while($doc = $documents_res->fetch_assoc()): ?>
                                <a href="<?= $doc['Document_Path'] ?>" target="_blank" class="list-group-item list-group-item-action py-3 doc-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                            <span class="fw-bold"><?= htmlspecialchars($doc['Document_Type']) ?></span>
                                        </div>
                                        <i class="bi bi-download"></i>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-folder-x fs-1 text-muted"></i>
                            <p class="text-muted">No documents uploaded for this contractor.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Additional Notes</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <?= !empty($contractor['Additional_Notes']) ? nl2br(htmlspecialchars($contractor['Additional_Notes'])) : 'No additional notes provided.' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
                        </div>
                    </div>
                </div>
            </main>
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
