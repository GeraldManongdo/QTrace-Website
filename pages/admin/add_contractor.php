<?php 
  $current_page = 'addContractor'; 
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
    <meta name="description" content="Register a new contractor in the QTRACE system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Add New Contractor</title>
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
        display: none;
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
                <li class="breadcrumb-item">
                  <a href="/QTrace-Website/dashboard">Home</a>
                </li>
                <li class="breadcrumb-item active">Add New Contractor</li>
              </ol>
            </nav>
            <div class="row mb-2">
              <div class="col">
                <!-- Page Header -->
                <h2 class="fw-bold">Add New Contractor</h2>
                <p>Register a new contractor in the QTRACE system</p>
              </div>
            </div>
          
            <!-- Form Section -->
            <div class="row g-3">
              <div class="col-12 card border-0 shadow-sm p-3">
                <form method="POST" action="/QTrace-Website/database/controllers/add_contractor.php" enctype="multipart/form-data" >
                  <div class="row g-3 mb-4">
                    <legend>Company Information</legend>
                    <hr class="m-1" />
                    <div class="col-md-4"></div>
                    <div class="row">
                      <div class="col-sm-4 mb-4 mb-lg-0">
                        <label class="validationDefault01 mb-2 fw-medium color-black">Company Logo</label>
                        <div class="preview-zone mb-3" id="drop-zone">
                          <button type="button" class="btn-remove" id="btnRemove">
                            <i class="bi bi-x"></i>
                          </button>
                          <div id="placeholder" class="text-center p-3">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                            <p class="mb-0 mt-2 fw-medium">Upload Image</p>
                            <small class="text-muted">Supports JPG, PNG, JPEG</small>
                          </div>
                          <img src="" id="preview-img" />
                        </div>
                        <input class="form-control" type="file" name="company_logo" id="imageInput" accept=".jpg, .jpeg, .png" required/>
                        <div id="error-msg" class="text-danger small mt-2"></div>
                      </div>

                      <div class="col-sm-8">
                        <div class="row">
                          <div class="col-md-12 mb-4">
                            <label for="validationDefault02" class="form-label fw-medium color-black">Company Name</label>
                            <input type="text" class="form-control" name="company_name" placeholder="e.g.,ABC Construction Inc." required />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 mb-4">
                            <label for="validationDefault03" class="form-label fw-medium color-black">Owner/Authorized Representative</label>
                            <input type="text" class="form-control" name="owner_name" placeholder="e.g.,Juan Dela Cruz" required/>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 mb-4">
                            <label for="validationDefault04" class="form-label fw-medium color-black" >Business Address</label>
                            <textarea class="form-control" name="business_address" rows="6" placeholder="Complete business address..." required></textarea>
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
                      <input type="number" class="form-control" name="contact_number" placeholder="+639 9999 9999" required />
                    </div>
                    <div class="col-md-6">
                      <label for="validationDefaultEmail" class="form-label fw-medium color-black" >Email</label >
                      <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                        <input type="email" class="form-control" name="email" id="validationDefaultEmail" aria-describedby="inputGroupPrepend2" placeholder="e.g., example@example.com" required />
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 mb-4">
                    <legend>Legal Documents</legend>
                    <hr class="m-1" />
                    <div>
                      <div
                        class="form-label d-flex justify-content-between align-items-center">
                        <label class="fw-medium color-black mb-0">Documents</label>
                        <button type="button" id="addDocument" class="btn btn-warning fw-medium bg-color-accent">+ Add Document </button>
                      </div>

                      <div id="documentWrapper">
                        <div class="mb-2 document-row row g-3">
                          <div class="col-md-3">
                            <input type="text" name="document_names[]" class="form-control" placeholder="e.g., Contract Agreement" required />  
                          </div>
                          <div class="col-md-9">
                            <input type="file" name="document_files[]" class="form-control" accept="application/pdf" required />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row g-3 mb-4">
                    <legend>Expertise & Experience</legend>
                    <hr class="m-1" />
                    <div>
                      <div class="form-label d-flex justify-content-between">
                        <label class="form-label fw-medium color-black">Expertises</label>
                        <button type="button" id="addSkill" class="btn btn-warning fw-medium bg-color-accent">+ Add Expertise</button>
                      </div>

                      <div id="skillWrapper">
                        <div class="input-group mb-2">
                          <input type="text" name="expertise[]" class="form-control" placeholder="Enter skill" required />
                        </div>
                      </div>
                    </div>
                    <div>
                      <label class="form-label fw-medium color-black" for="yearsOfExperience" >Years of Experience</label>
                      <input type="number" name="years_experience" class="form-control" placeholder="e.g., 5" required/>
                    </div>
                    <div>
                      <label class="form-label fw-medium color-black">Additional Notes</label>
                      <textarea class="form-control" name="additional_notes" rows="4" placeholder="Additional information about contractor..."></textarea>
                    </div>
                  </div>

                  <div class="row mt-4 g-3">
                    <div class="col-6">
                      <button class="btn btn-outline-secondary w-100 fw-medium" type="reset">
                        Cancel
                      </button>
                    </div>
                    <div class="col-6">
                      <button class="btn bg-color-primary text-light w-100 fw-medium" type="submit">
                        Add
                      </button>
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
