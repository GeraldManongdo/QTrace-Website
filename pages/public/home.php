<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Welcome to QTRACE, Quezon City's official platform for monitoring government projects and ensuring transparency."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Home</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
      /* Image Preview Box */
        .hero-section {
            background: linear-gradient(rgba(26, 57, 91, 0.9), rgba(31, 57, 85, 0.8)), 
                url('/QTrace-Website/assets/image/Hero-Bg.jpg');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            min-height:650px; 
            display: flex;
            align-items: center;
            color: white;
        }
        .search-bar {
            border-radius: 10px;
            padding: 15px 25px;
            border: none;
        }
        .stat-card-container {
            margin-top: -60px; /* Overlaps the hero section */
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            height: 100%;
        }
        .badge-qc {
            background-color: var(--accent);
            color: #333;
            border-radius: 50px;
        }
    </style>
    <body>
        <?php
            include('../../components/topNavigation.php');
        ?>
        <main>
            <section class="hero-section">
                <div class="container text-start">
                    <span class="badge badge-qc mb-4 fw-normal py-2 px-3 fs-6"> Official Quezon City Platform</span>
                    <h1 class="display-4 fw-medium">Transparency in Every Project</h1>
                    <p class="lead col-md-8 mb-5 fw-normal fs-4">
                        Track government projects, monitor progress, and report issues. QTRACE empowers 
                        Quezon City citizens to see where public funds go and ensure accountability.
                    </p>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group mb-3 shadow-sm rounded-3 overflow-hidden bg-white">
                                <span class="input-group-text  border-0 ps-3 fs-5">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0 py-3 fs-5" placeholder="Search for projects, barangays, or contractors...">
                                <button class="btn bg-color-primary text-light px-4 m-2" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container stat-card-container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card stat-card p-4" style="background-color: #f0fff4;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-0">3</h2>
                                    <p class="text-muted small mb-0">Active Projects</p>
                                </div>
                                <div class="py-2 px-3 bg-white rounded shadow-sm">
                                    <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-4" style="background-color: #f0f7ff;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-0">1</h2>
                                    <p class="text-muted small mb-0">Completed Projects</p>
                                </div>
                                <div class="py-2 px-3 bg-white rounded shadow-sm">
                                    <i class="bi bi-check-circle text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card p-4" style="background-color: #fdf2ff;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-0">1</h2>
                                    <p class="text-muted small mb-0">Resolved Citizen Reports</p>
                                </div>
                                <div class="py-2 px-3 bg-white rounded shadow-sm">
                                    <i class="bi bi-file-earmark-check text-purple fs-4" style="color: #6f42c1;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container text-center py-5 mt-5">
                <div class="title-section mb-4">
                    <h2 class="fw-bold">How QTRACE Works</h2>
                    <p class="text-muted">Four simple steps to participate in transparent governance</p>
                </div>

                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class=" p-4">
                                <div class="align-items-center">
                                    <div class="py-3 px-4 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-people text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-6 mb-1">Register with QC ID</h3>
                                        <p class="text-muted small mb-0 fs-8">Verify your identity as a Quezon City resident using your official QC ID number</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class=" p-4">
                                <div class="align-items-center">
                                    <div class="py-3 px-4 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-eye text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-6 mb-1">View Projects</h3>
                                        <p class="text-muted small mb-0 fs-8">Browse the interactive map to see all ongoing and planned projects in your area</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class=" p-4">
                                <div class="align-items-center">
                                    <div class="py-3 px-4 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-file-check text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-6 mb-1">Monitor Progress</h3>
                                        <p class="text-muted small mb-0 fs-8">Check project timelines, budgets, documents, and real-time photo updates</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class=" p-4">
                                <div class="align-items-center">
                                    <div class="py-3 px-4 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-shield text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-6 mb-1">Report Issues</h3>
                                        <p class="text-muted small mb-0 fs-8">Found a problem? Submit a report with photos and get official responses</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container text-center py-5 mt-4">
                <div class="card bg-color-primary text-light py-4 rounded-5" style="width: 100%;margin:auto;">
                    <div class="card-body p-5">
                        <div class="title-section mb-1 py-lg-4 px-lg-5">
                            <h2 class="fw-bold fs-3 mb-3">Start Exploring Public Projects</h2>
                            <p class="fs-6">View our interactive map to see what's happening in your barangay. All project data is updated in real-time by city officials.</p>
                        </div>
                        <div class="d-grid d-md-flex justify-content-md-center gap-3 gap-md-5">
                            <button class="btn px-5 py-2 fw-bold text-white" style="background-color: var(--accent) !important;">
                                Explore Project Map
                            </button>
                            <button class="btn btn-light border px-5 py-2 fw-bold">
                                Sign In with QC ID
                            </button>
                        </div>
                    </div>
                    </div>
            </section>

            <section class="container text-center py-5 mt-4">
                <div class="title-section mb-4">
                    <h2 class="fw-bold">Platform Features</h2>
                </div>
                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Real-Time Updates</h3>
                                        <p class="text-muted small mb-0 fs-8">Track project progress with live photo uploads, milestone completions, and status changes.</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Document Transparency</h3>
                                        <p class="text-muted small mb-0 fs-8">Access all public documents including contracts, permits, and environmental clearances.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Citizen Participation</h3>
                                        <p class="text-muted small mb-0 fs-8">Report issues, provide feedback, and receive official responses from city administrators.</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
        </main>
        <?php
            include('../../components/footer.php');
        ?>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>