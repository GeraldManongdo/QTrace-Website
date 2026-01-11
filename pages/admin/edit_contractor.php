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
        <meta name="description" content="Edit details of a verified contractor in the QTRACE system."/>
        <meta name="author" content="Confractus" />
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Edit | <?= htmlspecialchars($contractor['Contractor_Name']) ?></title>
        <!-- Bootstrap CSS Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
        <!-- General Css Link -->
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
        <!-- Custome Css For This Page Only  -->
        <style>
        /* Image Preview Box */
        .preview-zone {
            width: 100%;
            height: 300px;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            position: relative;
            overflow: hidden;
        }
        #preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            display: none;
            background: var(--qc-red);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }
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
                                <li class="breadcrumb-item"><a href="/QTrace-Website/contractor-list">Contractor List</a></li>
                                <li class="breadcrumb-item"><a href="/QTrace-Website/pages/admin/view_contractor?id=<?= htmlspecialchars($contractor['Contractor_Id']) ?>">Contractor Details</a></li>
                                <li class="breadcrumb-item active">Edit Contractor</li>
                            </ol>
                </nav>
                <div class="row mb-2">
                <div class="col">
                    <!-- Page Header -->
                    <h2 class="fw-bold">Edit Contractor</h2>
                    <p>Edit details of a verified contractor in the QTRACE system</p>
                </div>
                </div>
            
                <!-- Form Section -->
                <div class="row g-3">
                    <div class="col-12 card border-0 shadow-sm p-3">
                        <form method="POST" action="/QTrace-Website/database/controllers/edit_contractor.php" enctype="multipart/form-data" >
                            <input type="hidden" name="contractor_id" value="<?= $contractor_id ?>">
                            <div class="row g-3 mb-4">
                                <legend>Company Information</legend>
                                <hr class="m-1" />
                                <div class="col-md-4"></div>
                                <div class="row">
                                    <div class="col-sm-4 mb-4 mb-lg-0">
                                        <label class="mb-2 fw-medium color-black">Company Logo</label>
                                        
                                        <div class="preview-zone mb-3" id="drop-zone" style="cursor: pointer;" onclick="document.getElementById('imageInput').click();">
                                            <?php 
                                                $logoPath = !empty($contractor['Contractor_Logo_Path']) ? $contractor['Contractor_Logo_Path'] : '';
                                                $hasLogo = !empty($logoPath) && file_exists($logoPath);
                                            ?>
                                            
                                            <img src="<?= $hasLogo ? $logoPath : 'https://via.placeholder.com/150' ?>" 
                                                id="preview-img" 
                                                style="display: block; width: 100%; height: 100%; object-fit: cover;" />
                                            
                                            <div id="placeholder-icon" class="text-center" style="display: <?= $hasLogo ? 'none' : 'block' ?>;">
                                                <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                                                <p class="mb-0 small">Click to change</p>
                                            </div>
                                        </div>

                                        <input class="form-control" type="file" name="company_logo" id="imageInput" accept=".jpg, .jpeg, .png" />
                                        <small class="text-muted">Leave blank to keep the current logo.</small>
                                        <div id="error-msg" class="text-danger small mt-2"></div>
                                    </div>

                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationDefault02" class="form-label fw-medium color-black">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" placeholder="e.g.,ABC Construction Inc." value="<?= htmlspecialchars($contractor['Contractor_Name']) ?>" required />
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationDefault03" class="form-label fw-medium color-black">Owner/Authorized Representative</label>
                                            <input type="text" class="form-control" name="owner_name" placeholder="e.g.,Juan Dela Cruz" value="<?= htmlspecialchars($contractor['Owner_Name']) ?>"  required/>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label for="validationDefault04" class="form-label fw-medium color-black" >Business Address</label>
                                            <textarea class="form-control" name="business_address" rows="6" placeholder="Complete business address..." required><?= htmlspecialchars($contractor['Company_Address']) ?></textarea>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <legend>Contact Information</legend>
                                <hr class="m-1" />
                                <div class="col-md-6">
                                    <label class="form-label fw-medium color-black" for="contactNumber">Contact Number</label>
                                    <input type="number" class="form-control" name="contact_number" placeholder="+639 9999 9999" value="<?= htmlspecialchars($contractor['Contact_Number']) ?>"  required />
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefaultEmail" class="form-label fw-medium color-black" >Email</label >
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                        <input type="email" class="form-control" name="email" id="validationDefaultEmail" aria-describedby="inputGroupPrepend2" placeholder="e.g., example@example.com" value="<?= htmlspecialchars($contractor['Company_Email_Address']) ?>"  required />
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <legend class="fw-bold">Legal Documents</legend>
                                <hr class="m-1" />
                                <div>
                                    <div class="form-label d-flex justify-content-between align-items-center">
                                        <label class="fw-medium color-black mb-0">Upload New Documents</label>
                                        <button type="button" id="addDocument" class="btn btn-warning btn-sm fw-medium bg-color-accent">
                                            <i class="bi bi-plus-lg"></i> Add Row
                                        </button>
                                    </div>

                                    <div id="documentWrapper">
                                        <div class="mb-2 document-row row g-2">
                                            <div class="col-md-4">
                                                <input type="text" name="document_names[]" class="form-control" placeholder="Document Name (e.g. Renewal)" />  
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" name="document_files[]" class="form-control" accept="application/pdf" />
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Files uploaded here will be added to the existing list.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="fw-medium color-black mb-2">Currently Uploaded Documents</label>
                                    <div class="list-group">
                                        <?php 
                                        $documents_res->data_seek(0);
                                        if ($documents_res->num_rows > 0): 
                                            while ($doc = $documents_res->fetch_assoc()): 
                                        ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center bg-light ">
                                                <div>
                                                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                    <span class="fw-medium"><?= htmlspecialchars($doc['Document_Type']) ?></span>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="<?= $doc['Document_Path'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                    </div>
                                            </div>
                                        <?php 
                                            endwhile; 
                                        else: 
                                        ?>
                                            <p class="text-muted small ps-2">No documents currently uploaded.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                
                            </div>

                            <div class="row g-3 mb-4">
                                <legend>Expertise & Experience</legend>
                                <hr class="m-1" />
                                <div class="form-label d-flex justify-content-between">
                                    <label class="form-label fw-medium color-black">Expertises</label>
                                    <button type="button" id="addSkill" class="btn btn-warning fw-medium bg-color-accent">+ Add Expertise</button>
                                </div>

                                <div id="skillWrapper">
                                    <?php 
                                    // Reset the result pointer for expertise
                                    $expertise_res->data_seek(0);
                                    
                                    if ($expertise_res->num_rows > 0): 
                                        while ($exp = $expertise_res->fetch_assoc()): 
                                    ?>
                                        <div class="input-group mb-2 expertise-row">
                                            <input type="text" name="expertise[]" class="form-control" 
                                                value="<?= htmlspecialchars($exp['Expertise']) ?>" required />
                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    <?php 
                                        endwhile; 
                                    else: 
                                    ?>
                                        <div class="input-group mb-2 expertise-row">
                                            <input type="text" name="expertise[]" class="form-control" placeholder="Enter skill" required />
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <label class="form-label fw-medium color-black" for="yearsOfExperience" >Years of Experience</label>
                                    <input type="number" name="years_experience" class="form-control" placeholder="e.g., 5" value="<?= htmlspecialchars($contractor['Years_Of_Experience']) ?>"  required/>
                                </div>
                                <div>
                                    <label class="form-label fw-medium color-black">Additional Notes</label>
                                    <textarea class="form-control" name="additional_notes" rows="4" placeholder="Additional information about contractor..."><?= htmlspecialchars($contractor['Additional_Notes']) ?></textarea>
                                </div>
                            </div>

                            <div class="row mt-4 g-3">
                                <div class="col-6">
                                <a href="/QTrace-Website/pages/admin/view_contractor?id=<?= htmlspecialchars($contractor['Contractor_Id']) ?>" class="btn btn-outline-secondary w-100 fw-medium">Contractor Details</a>
                                </div>
                                <div class="col-6">
                                <button class="btn bg-color-primary text-light w-100 fw-medium" type="submit"> Update </button>
                                </div>
                            </div>
                        </form>
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
    <script src="/QTrace-Website/assets/js/imageholder.js"></script>
    <script src="/QTrace-Website/assets/js/dynamicFieldText.js"></script>
    <script src="/QTrace-Website/assets/js/dynamicFieldFile.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
