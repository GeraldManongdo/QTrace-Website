<?php 
    $current_page = 'aboutUs';
    require('../../database/controllers/get_data.php');
?>

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
            min-height:400px;
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
    <body class="bg-color-background">
        <?php
            include('../../components/topNavigation.php');
        ?>
        <main>
            <section class="hero-section">
                <div class="container text-center">
                    <span class="badge badge-qc mb-4 fw-normal py-2 px-3 fs-6"> Transparency & Accountability</span>
                    <h1 class="display-4 fw-medium">About QTrace</h1>
                    <p class="lead mb-5 fw-normal fs-4 w-75 m-auto">
                        Build a transparent and accountable Quezon City through technology and citizen engagement
                    </p>
                </div>
            </section>
 
            <section class="container-fluid  text-center py-5 mt-4">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <div class="py-1 px-2 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                            <i class="bi bi-bullseye text-light fs-5"></i>
                                        </div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Our Mission</h3>
                                        <p class="text-muted small mb-0 fs-6">To empower Quezon City citizens with real-time access to government project information, fostering transparency,
                                        accountability, and active civic participation in local governance. QTRACE ensures that every peso spent on public infrastructure is visible, tracked,
                                        and accountable to the people it serves.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-sm-6">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <div class="py-1 px-2 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                            <i class="bi bi-eye text-light fs-5"></i>
                                        </div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Our Vision</h3>
                                        <p class="text-muted small mb-0 fs-6">To establish Quezon City as a model of digital governance in the Philippines, where technology bridges the gap between government and citizens.
                                            We envision a future where every citizen can actively monitor, engage with, and contribute to the development of their community through transparent and accessible platforms.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
 
            <section class="container-fluid bg-white text-center py-5 my-5">
                <div class="title-section mb-4">
                    <h2 class="fw-medium">What is QTrace?</h2>
                    <p class="text-muted lead mb-5 w-75 m-auto">QTRACE (Quezon City Transparency, Accountability, and Citizen Engagement) is the official digital platform of the Quezon City Government
                        designed to provide complete transparency in public infrastructure projects and government initiatives.</p>
                </div>

                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3" >
                                <div class="text-start">
                                    <div class="px-2 py-1 mb-3 rounded shadow-sm d-inline-flex align-items-center justify-content-center" style="background-color: #edfded;">
                                        <i class="bi bi-hourglass-split text-success fs-4 "></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Real-Time Tracking</h3>
                                        <p class="text-muted small mb-0">Monitor government projects from planning to completion with live updates and progress reports.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3" >
                                <div class="text-start">
                                    <div class="px-2 py-1 mb-3 rounded shadow-sm d-inline-flex align-items-center justify-content-center" style="background-color: #f3fbfd;">
                                        <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Document Verification</h3>
                                        <p class="text-muted small mb-0 ">Access official project documents, budgets, and contractor information for full transparency.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3" >
                                <div class="text-start">
                                    <div class="px-2 py-1 mb-3 rounded shadow-sm d-inline-flex align-items-center justify-content-center" style="background-color: #fff8e3;">
                                        <i class="bi bi-people text-warning fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Citizen Reporting</h3>
                                        <p class="text-muted small mb-0">Report issues, concerns, or observations directly to government officials for immediate action.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
 
            <section class="container text-center py-5 my-5">
                <div class="title-section mb-4">
                    <h2 class="fw-bold">Our Core Values</h2>
                    <p class="text-muted lead mb-5 w-75 m-auto">The principles that guide QTrace in serving the people of Quezon City</p>
                </div>
                
                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-center">
                                    <div class="py-2 px-3 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-shield text-light fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Integrity</h3>
                                        <p class="text-muted text-center small mb-0 ">Maintaining the highest standards of honesty and transparency in all operations.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-3">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-center">
                                    <div class="py-2 px-3 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-heart text-light fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Service</h3>
                                        <p class="text-muted text-center small mb-0 ">Dedicated to serving the citizens of Quezon City with excellence and compassion.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-center">
                                    <div class="py-2 px-3 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-graph-up-arrow text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Innovation</h3>
                                        <p class="text-muted text-center small mb-0 ">Leveraging technology to continuously improve governance and public service delivery.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-center">
                                    <div class="py-2 px-3 rounded-circle bg-color-primary shadow-sm mb-3 d-inline-block">
                                        <i class="bi bi-people text-light fs-3"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Collaboration</h3>
                                        <p class="text-muted text-center small mb-0 ">Building partnerships between government, citizens, and contractors for community progress.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container-fluid bg-white text-center py-5 my-5">
                <div class="title-section mb-4">
                    <h2 class="fw-medium">Quezon City Government</h2>
                    <p class="text-muted lead mb-5 w-75 m-auto">Leadership committed to transparency, accountability, and innovative governance</p>
                </div>
                <div class="container mb-4">
                    <div class="card stat-card py-4 px-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="py-2 px-3 rounded-circle bg-color-primary shadow-sm flex-shrink-0">
                                <i class="bi bi-building text-light fs-3"></i>
                                </div>
                                    <div>
                                        <h3 class="fw-medium text-start mb-0 fs-4">Office of the Mayor</h3>
                                        <p class="text-muted text-start mb-0 fs-6">Quezon City Government</p>
                                    </div>
                        </div>
                            <div class="mt-3">
                                <p class="text-muted text-start mb-2 fs-6">The Quezon City Government is committed to implementing digital governance solutions that promote transparency and citizen engagement. 
                                    QTRACE represents our dedication to ensuring that every citizen has access to information about government projects and public spending.</p>
                                <p class="text-muted text-start mb-0 fs-6">Through QTRACE, we aim to build trust between the government and the people, foster collaboration, and create a more accountable and responsive local government.</p>
                            </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Engineering Department</h3>
                                        <p class="text-muted small mb-0 fs-7">Oversees infrastructure projects, ensuring quality construction and timely completion.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Budget Office</h3>
                                        <p class="text-muted small mb-0 fs-7">Manages public funds allocation and ensures transparent financial reporting.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-4">
                            <div class="card stat-card py-4 px-3">
                                <div class="text-start">
                                    <div>
                                        <h3 class="fw-medium mb-0 fs-5 mb-2">Public Affairs Office</h3>
                                        <p class="text-muted small mb-0 fs-7">Facilitates citizen engagement and handles public inquiries and feedback.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
             
            <section class="container text-center py-5 mt-4">
                <div class="title-section mb-4">
                    <h2 class="fw-medium">Our Impact</h2>
                    <p class="text-muted lead mb-5 w-75 m-auto">Making a difference through transparency and accountability</p>
                </div>

                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="card stat-card p-4">
                                <div class="text-center">
                                    <div class="fs-1 text-primary-emphasis"><?php echo $active_count; ?>+</div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Active Projects</h3>
                                        <p class="text-muted text-center small mb-0 ">Currently being tracked and monitored</p>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-md-3">
                            <div class="card stat-card p-4">
                                <div class="text-center">
                                    <div class="fs-1 text-primary-emphasis"><?php echo $completed_count; ?></div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Completed Projects</h3>
                                        <p class="text-muted text-center small mb-0 ">Successfully delivered to communities</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card stat-card p-4">
                                <div class="text-center">
                                    <div class="fs-1 text-primary-emphasis"><?php echo $citizens_count; ?>+</div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Registered Citizens</h3>
                                        <p class="text-muted text-center small mb-0 ">Actively engaged in monitoring</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card stat-card p-4">
                                <div class="text-center">
                                    <div class="fs-1 text-primary-emphasis"><?php echo $percentage; ?>%</div>
                                    <div>
                                        <h3 class="fw-medium text-center mb-0 fs-5 mb-2">Report Resolution</h3>
                                        <p class="text-muted text-center small mb-0 ">Citizen concerns addressed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        

             <section class=" text-center py-4 mt-4">
                <div class="card bg-color-primary text-light py-4 rounded-0">
                    <div class="card-body p-5">
                        <div class="title-section mb-1 py-lg-4 px-lg-5">
                            <h2 class="fw-bold fs-3 mb-3">Join the Movement</h2>
                            <p class="fs-6">Be part of building a more transparent and accountable Quezon City. Register today and start monitoring projects in your community.</p>
                        </div>
                        <div class="d-grid d-md-flex justify-content-md-center gap-3 gap-md-5">
                            <button class="btn px-5 py-2 fw-bold text-white" style="background-color: var(--accent) !important;" onclick="window.location.href='/QTrace-Website/login'">
                                Register As Citizen
                            </button>
                            <button class="btn btn-light border px-5 py-2 fw-bold" onclick="window.location.href='/QTrace-Website/projects'">
                                Explore Projects
                            </button>
                        </div>
                    </div>
                    </div>
            </section>

            <section class="container text-center py-5 mt-4">
                <div class="card stat-card p-5">
                    <h2 class="fw-bold mb-5">Get in Touch</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="bi bi-building text-primary fs-1"></i>
                                </div>
                                <h3 class="fw-semibold fs-5 mb-3">Visit Us</h3>
                                <p class="text-muted mb-1">Quezon City Hall</p>
                                <p class="text-muted mb-1">Elliptical Road, Diliman</p>
                                <p class="text-muted mb-0">Quezon City, Metro Manila</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="bi bi-people text-success fs-1"></i>
                                </div>
                                <h3 class="fw-semibold fs-5 mb-3">Contact Us</h3>
                                <p class="text-muted mb-1">Phone: +63 2 8988 4242</p>
                                <p class="text-muted mb-1">Email: qtrace@quezoncity.gov.ph</p>
                                <p class="text-muted mb-0">Hotline: 122 (QC Hotline)</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="bi bi-globe text-primary fs-1"></i>
                                </div>
                                <h3 class="fw-semibold fs-5 mb-3">Office Hours</h3>
                                <p class="text-muted mb-1">Monday - Friday</p>
                                <p class="text-muted mb-1">8:00 AM - 5:00 PM</p>
                                <p class="text-muted mb-0">(Except Holidays)</p>
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