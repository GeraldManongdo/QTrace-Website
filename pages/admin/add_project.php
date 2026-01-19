<?php
$page_name = 'addProject';
require_once '../../database/connection/connection.php';

// Preload contractors for server-rendered dropdown
$contractors = [];
$contractorStmt = $conn->prepare("SELECT Contractor_Id, Contractor_Name FROM contractor_table ORDER BY Contractor_Name ASC");
if ($contractorStmt) {
  $contractorStmt->execute();
  $result = $contractorStmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $contractors[] = $row;
  }
  $contractorStmt->close();
}

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Register a new project in the QTRACE system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Add New Project</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <style>
        #map-picker { 
          height: 500px; 
          border-radius: 
          8px; margin-bottom: 15px; 
          cursor: crosshair; 
        }
        .form-container { 
          max-width: 800px; 
          margin: 30px auto; 
          padding: 20px; 
          background: #fff; 
          box-shadow: 0 0 10px rgba(0,0,0,0.1); }

        .step-pane { display: none; }
        .step-pane.active { display: block; }
        .preview-img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; }
        .card { border: none; border-radius: 12px; }
        /* Validation Styles */
        .is-invalid-step .form-control:invalid { border-color: #dc3545; }

        #imageWrapper { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .image-card { 
            background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 15px; 
            position: relative; transition: box-shadow 0.3s;
        }
        .image-card:hover { box-shadow: 0 10px 15px rgba(0,0,0,0.05); }
        .preview-container { 
            width: 100%; height: 160px; background: #f8f9fa; border-radius: 8px; 
            display: flex; align-items: center; justify-content: center; margin-bottom: 15px; 
            overflow: hidden; border: 2px dashed #dee2e6;
        }
        .preview-box { width: 100%; height: 100%; object-fit: cover; display: none; }
        .preview-placeholder { color: #adb5bd; font-size: 2rem; }
        
        .remove-img-btn { position: absolute; top: -10px; right: -10px; border-radius: 50%; padding: 5px 10px; }
    </style>
</head>
<body class="bg-light">
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
                <li class="breadcrumb-item active">Add New Project</li>
              </ol>
            </nav>
            <div class="row mb-2">
              <div class="col">
                <!-- Page Header -->
                <h2 class="fw-bold">Add New Project</h2>
                <p>Register a new project in the QTRACE system</p>
              </div>
            </div>
          
            <!-- Form Section -->
            <div class="row g-3">
              <div class="col-12 card border-0 shadow-sm p-3">

                
                <form method="POST" action="/QTrace-Website/database/controllers/add_project.php" id="multiStepForm" enctype="multipart/form-data" novalidate>
                  <!-- Project Information -->
                  <div class="step-pane active" id="p0">
                    <legend>Project Information</legend>
                    <hr class="m-1" />
                    <div class="col-md-12 mb-4 mt-2">
                      <label for="project_title" class="form-label fw-medium color-black">Project Title</label>
                      <input type="text" class="form-control" name="Project_Title" id="project_title" placeholder="e.g., Road Widening Project" required />
                      <div class="invalid-feedback">Please provide a project title.</div>
                    </div>
                                        
                    <div class="col-md-12 mb-4">
                      <label for="project_description" class="form-label fw-medium color-black">Project Description</label>
                      <textarea class="form-control" name="Project_Description" id="project_description" rows="4" placeholder="Describe the project details..." required></textarea>
                      <div class="invalid-feedback">Please provide a project description.</div>
                    </div>

                    <div class="row">
                      <div class="col-md-4 mb-4">
                        <label for="contractor_id" class="form-label fw-medium color-black">Project Contractor</label>
                        <select class="form-select" name="Contractor_ID" id="contractor_id" required>
                          <option value="" selected disabled>Select Contractor</option>
                          <?php foreach ($contractors as $contractor): ?>
                            <option value="<?php echo htmlspecialchars($contractor['Contractor_Id']); ?>">
                              <?php echo htmlspecialchars($contractor['Contractor_Name']); ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a project contractor.</div>
                      </div>

                      <div class="col-md-4 mb-4">
                        <label for="status_id" class="form-label fw-medium color-black">Project Status</label>
                        <select class="form-select" name="Project_Status" id="status_id" required>
                          <option value="" selected disabled>Select Status</option>
                          <option value="Planning">Planning</option>
                          <option value="Ongoing">Ongoing</option>
                          <option value="Completed">Completed</option>
                          <option value="Delayed">Delayed</option>
                        </select>
                        <div class="invalid-feedback">Please select a project status.</div>
                      </div>

                      <div class="col-md-4 mb-4">
                        <label for="status_id" class="form-label fw-medium color-black">Project Category</label>
                        <select class="form-select" name="Project_Category" id="category_id" required>
                          <option value="" selected disabled>Select Category</option>
                          <option value="Infrastructure">Infrastructure</option>
                          <option value="Environmental">Environmental</option>
                          <option value="Social Services">Social Services</option>
                          <option value="Safety">Safety</option>
                        </select>
                        <div class="invalid-feedback">Please select a project category.</div>
                      </div>

                    </div>

                    <div class="row g-3 mb-4">
                    <legend>Location</legend>
                    <hr class="m-1" />
                    
                    <div class="col-md-12 mb-2">
                      <div id="map-picker"></div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-4 mb-4">
                        <label for="street" class="form-label fw-medium color-black">Street</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="e.g., Main St."  required/>
                        <div class="invalid-feedback">Please enter the street.</div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="barangay" class="form-label fw-medium color-black">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="e.g., Barangay 123" required />
                        <div class="invalid-feedback">Please enter the barangay.</div> 
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="zip_code" class="form-label fw-medium color-black">Zip Code</label>
                        <input type="number" class="form-control" id="zip_code" name="zip_code" placeholder="e.g., 12345" required />
                          <div class="invalid-feedback">Please enter the zip code.</div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-4">
                        <label for="lat" class="form-label fw-medium color-black">Latitude</label>
                        <input type="text" class="form-control" id="lat" name="lat" readonly required/>
                        <div class="invalid-feedback">Please enter the latitude.</div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <label for="lng" class="form-label fw-medium color-black">Longitude</label>
                        <input type="text" class="form-control" id="lng" name="lng" readonly required />
                        <div class="invalid-feedback">Please enter the longitude.</div>
                      </div>

                    </div>
                  </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn bg-color-primary text-light px-4 next-btn">Next Step</button>
                    </div>
                </div>

                  <div class="step-pane" id="p1">
                    <div class="row g-3 mb-4">
                      <legend>Budget & Timeline</legend>
                      <hr class="m-1" />
                      <div class="col-md-12 mb-4">
                        <label for="project_budget" class="form-label fw-medium color-black">Project Budget</label>
                        <input type="number" step="0.01" class="form-control" name="Project_Budget" id="project_budget" placeholder="e.g., 1000000.00" required />
                        <div class="invalid-feedback">Please enter the project budget.</div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <label for="start_date" class="form-label fw-medium color-black">Start Date</label>
                        <input type="date" class="form-control" name="Project_StartedDate" id="start_date" required />
                        <div class="invalid-feedback">Please enter the start date.</div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <label for="end_date" class="form-label fw-medium color-black">End Date</label>
                        <input type="date" class="form-control" name="Project_EndDate" id="end_date" required />
                        <div class="invalid-feedback">Please enter the end date.</div>  
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
                              <div class="invalid-feedback">Please enter the document name.</div>  
                            </div>
                            <div class="col-md-9">
                              <input type="file" name="document_files[]" class="form-control" accept="application/pdf" required />
                              <div class="invalid-feedback">Please upload the document file.</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light prev-btn">Back</button>
                        <button type="button" class="btn btn-warning fw-medium  bg-color-primary px-4 next-btn">Next Step</button>
                    </div>
                  </div>

                  <div class="step-pane " id="p2">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <legend style="width: auto;">Milestone Gallery</legend>
                      <button type="button" class="btn bg-color-accent text-light" id="addImage">
                          <i class="bi bi-plus-circle me-2"></i>Add Image
                      </button>
                    </div>
                    <hr class="m-1 mb-3" />

                    <div id="imageWrapper" class="mb-3">
                        <div class="image-card">
                            <div class="preview-container">
                                <i class="bi bi-image preview-placeholder"></i>
                                <img src="" class="preview-box">
                            </div>
                            <div class="mb-2">
                                <select name="img_types[]" class="form-select form-select-sm" required>
                                    <option value="" selected disabled>Category...</option>
                                    <option value="site_progress">Site Progress</option>
                                    <option value="before_photo">Before Photo</option>
                                    <option value="after_photo">After Photo</option>
                                    <option value="inspection">Inspection</option>
                                </select>
                            </div>
                            <input type="file" name="img_files[]" class="form-control form-control-sm img-input" accept="image/*" required>
                            <button class="btn btn-danger btn-sm remove-img-btn remove-btn" type="button"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light prev-btn">Back</button>
                        <button type="submit" class="btn bg-color-primary text-light px-4 next-btn">Add Project</button>
                    </div>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </main>
    </div>  
  </div>


  
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Custome Script For This Page Only  --> 
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        // Initialize map
        const map = L.map('map-picker').setView([14.6760, 121.0437], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Fix for gray map issue in hidden containers
        setTimeout(() => { map.invalidateSize(); }, 500);

        let marker;

        async function updateAddressDetails(lat, lng) {
            try {
                document.getElementById('street').placeholder = "Fetching...";
                document.getElementById('barangay').placeholder = "Fetching...";

                // Use the absolute path from the web root
                const response = await fetch(`/QTrace-Website/database/controllers/get_address.php?lat=${lat}&lng=${lng}`);
                
                if (!response.ok) throw new Error("Controller not found");
                
                const data = await response.json();

                if (data && data.address) {
                    const addr = data.address;
                    document.getElementById('street').value = addr.road || addr.street || addr.pedestrian || "";
                    document.getElementById('barangay').value = addr.neighbourhood || addr.village || addr.suburb || addr.quarter || addr.city_district || "";
                    document.getElementById('zip_code').value = addr.postcode || "";
                }
            } catch (error) {
                console.error("Geocoding error:", error);
                document.getElementById('street').placeholder = "Error fetching address";
            }
        }

        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            if (marker) { marker.setLatLng(e.latlng); } 
            else { marker = L.marker(e.latlng).addTo(map); }

            updateAddressDetails(lat, lng);
        });

        // Step Navigation Logic (Simplified)
        document.querySelector('.next-btn').addEventListener('click', function() {
            document.getElementById('p0').classList.remove('active');
            document.getElementById('p1').classList.add('active');
        });

        document.querySelector('.prev-btn').addEventListener('click', function() {
            document.getElementById('p1').classList.remove('active');
            document.getElementById('p0').classList.add('active');
            setTimeout(() => { map.invalidateSize(); }, 100);
        });
    });
    </script>
         
    <!-- Reusable Script -->
    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="/QTrace-Website/assets/js/progressForm.js"></script>
    <script src="/QTrace-Website/assets/js/dynamicFieldFile.js"></script>
    <script src="/QTrace-Website/assets/js/dynamicFieldImage.js"></script>

    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>