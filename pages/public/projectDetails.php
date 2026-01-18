<?php 
    $current_page = 'projects'; 
    session_start();
    require('../../database/controllers/get_project_details.php');

        // Placeholder for reports count - you can replace this with a real DB count
    $report_count = 1; 
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Details of a Quezon City government project."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Project Details</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <!-- Map Link -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Custome Css For This Page Only  -->
    <style>
        .main-card { border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .status-pill { border-radius: 50px; padding: 4px 12px; font-size: 0.85rem; font-weight: 500; }
        .icon-box { width: 40px; height: 40px; background: rgba(26, 54, 93, 0.1); color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    
        /* Documents Styling */
        .doc-card { border: 1px solid var(--surface); border-radius: 10px; padding: 1.25rem; margin-bottom: 1rem; transition: background 0.2s; }
        .doc-card:hover { background-color: var(--background); }
        .doc-icon { background: rgba(26, 54, 93, 0.1); color: var(--primary); width: 45px; height: 45px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }

        /* Milestone/Gallery Styling */
        .gallery-card { border-radius: 12px; overflow: hidden; border: 1px solid var(--surface); transition: transform 0.2s; }
        .gallery-card:hover { transform: translateY(-5px); }
        .gallery-img { height: 200px; object-fit: cover; width: 100%; }
        
        /* Reports Styling */
        .report-card { border: 1px solid var(--surface); border-radius: 10px; padding: 1.5rem; }
        .official-response { background-color: rgba(26, 54, 93, 0.05); border-left: 4px solid var(--primary); border-radius: 4px; padding: 1rem; margin-top: 1rem; }
        
        /* Report List Styling */
        .report-item { 
            border: 1px solid var(--surface); 
            border-radius: 10px; 
            padding: 1.25rem; 
            margin-bottom: 1rem; 
            cursor: pointer; 
            transition: all 0.2s;
            background: white;
        }
        .report-item:hover { 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
            transform: translateY(-2px);
        }
        .report-item-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            margin-bottom: 0.75rem; 
        }
        .report-item-description { 
            margin-bottom: 0.75rem; 
            line-height: 1.5; 
        }
        .report-item-footer { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding-top: 0.75rem; 
            border-top: 1px solid var(--surface); 
        }
        
        /* Chat Interface Styling */
        #reportChatContainer { 
            position: fixed; 
            top: 0; 
            right: 0; 
            width: 450px; 
            height: 100vh; 
            background: white; 
            box-shadow: -4px 0 20px rgba(0,0,0,0.15); 
            z-index: 1050; 
            display: none;
            flex-direction: column;
        }
        .chat-header { 
            padding: 1.5rem; 
            border-bottom: 1px solid var(--surface); 
            background: var(--primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .chat-messages { 
            flex: 1; 
            overflow-y: auto; 
            padding: 1.5rem; 
            background: var(--background); 
        }
        .message { 
            margin-bottom: 1.5rem; 
            padding: 1rem; 
            border-radius: 10px; 
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .message-header { 
            display: flex; 
            align-items: center; 
            margin-bottom: 0.5rem; 
            gap: 0.5rem;
        }
        .message-content { 
            color: var(--text-dark); 
            line-height: 1.6; 
        }
        .original-report { 
            border-left: 4px solid var(--primary); 
            background: rgba(26, 54, 93, 0.05);
        }
        .admin-message { 
            border-left: 4px solid var(--secondary); 
        }
        .user-message { 
            border-left: 4px solid var(--accent); 
        }
        .system-message { 
            background: rgba(246, 173, 85, 0.15); 
            border: 1px solid var(--accent); 
            text-align: center;
            padding: 0.5rem;
            font-style: italic;
        }
        .chat-input { 
            padding: 1.5rem; 
            border-top: 1px solid var(--surface); 
            background: white;
        }
        .chat-input textarea { 
            width: 100%; 
            border: 1px solid var(--surface); 
            border-radius: 8px; 
            padding: 0.75rem; 
            resize: none; 
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }
        .chat-input textarea:focus { 
            outline: none; 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(26, 54, 93, 0.1);
        }
    </style>

    <body class="bg-color-background">
        <?php
            include('../../components/topNavigation.php');
        ?>
        <main>
            
        <section class="container py-5" >
            <nav aria-label="breadcrumb">
                <!-- Breadcrumb -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> <a href="/QTrace-Website/home">Home</a> </li>
                    <li class="breadcrumb-item"><a href="/QTrace-Website/projects">Project List</a></li>
                    <li class="breadcrumb-item active">Project Details</li>
                </ol>
            </nav>

            <div class="title-section mb-4">
                <h2 class="fw-bold">Project Details</h2>
                <p class="text-muted">Official details of a Quezon City government project.</p>
            </div>
            
            <div class="container-fluid py-2">
                        <div class="card main-card mb-4 ">
                            <div class="card-body py-5 px-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h3 class="fw-bold mb-3">
                                            <?php echo htmlspecialchars($project['ProjectDetails_Title']); ?>
                                        </h3>
                                        <p class="text-secondary mb-0"><?php echo htmlspecialchars($project['ProjectDetails_Description']); ?></p>
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-geo-alt-fill"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">LOCATION</small>
                                                <span class="fw-medium fs-8 text-dark"><?php echo htmlspecialchars($full_address); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-currency-exchange"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">BUDGET</small>
                                                <span class="fw-medium fs-8  text-dark">₱<?php echo formatShorthand($project['ProjectDetails_Budget']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 border-end">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-calendar-event"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">TIMELINE</small>
                                                <span class="fw-medium fs-8  text-dark"><?php echo date("Y-m-d", strtotime($project['ProjectDetails_StartedDate'])); ?> to <?php echo date("Y-m-d", strtotime($project['ProjectDetails_EndDate'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3"><i class="bi bi-grid-fill"></i></div>
                                            <div>
                                                <small class="text-muted d-block small fw-bold">CATEGORY</small>
                                                <span class="fw-medium fs-8  text-dark"><?php echo htmlspecialchars($project['Project_Category'] ?? 'N/A'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card main-card">
                            <div class="card-header bg-white border-0 p-2">
                                <ul class="nav nav-tabs details px-4 pt-2 pb-2 gap-3" id="projectTabs">
                                    <li class="nav-item "><button class="nav-link text-black-50 fw-medium  active" data-bs-toggle="tab" data-bs-target="#overview"><i class="bi bi-file-text me-2"></i>Overview</button></li>
                                    <li class="nav-item "><button class="nav-link text-black-50 fw-medium " data-bs-toggle="tab" data-bs-target="#docs"><i class="bi bi-folder2-open me-2"></i>Documents (<?php echo count($documents); ?>)</button></li>
                                    <li class="nav-item "><button class="nav-link text-black-50 fw-medium " data-bs-toggle="tab" data-bs-target="#gallery"><i class="bi bi-images me-2"></i>Photo Gallery (<?php echo count($milestones); ?>)</button></li>
                                    <li class="nav-item "><button class="nav-link text-black-50 fw-medium " data-bs-toggle="tab" data-bs-target="#reports"><i class="bi bi-chat-left-dots me-2"></i>Reports (<?php echo $report_count; ?>)</button></li>
                                </ul>
                            </div>
                            <div class="card-body p-4 tab-content">
                                
                                <div class="tab-pane fade show active" id="overview">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold mb-4">Project Details</h6>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Category:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['Project_Category'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Status:</span>
                                                <span class="status-pill" style="background-color: rgba(217, 38, 46, 0.1); color: var(--secondary);">● <?php echo htmlspecialchars($project['Project_Status']); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Total Budget:</span>
                                                <span class="fw-bold">₱<?php echo number_format($project['ProjectDetails_Budget'], 2); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 border-start ps-md-5">
                                            <h6 class="fw-bold mb-4">Project Team</h6>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Contractor:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['Contractor_Name'] ?? 'No Assigned Contractor'); ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="text-muted">Barangay:</span>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($project['ProjectDetails_Barangay']); ?></span>
                                            </div>
                                            <a href="/QTrace-Website/view-contractor?id=<?= $project['Contractor_ID'] ?>" class="btn btn-link p-0 text-decoration-none fw-bold mt-2" style="color: var(--primary)">View Contractor Profile →</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="docs">
                                    <p class="text-muted mb-4">All public documents related to this project. Documents are updated regularly by project administrators.</p>
                                    <?php foreach ($documents as $doc): ?>
                                    <div class="doc-card d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="doc-icon me-3"><i class="bi bi-file-earmark-text"></i></div>
                                            <div>
                                                <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($doc['ProjectDocument_Type']); ?></h6>
                                                <small class="text-muted">Uploaded on <?php echo date("Y-m-d", strtotime($doc['ProjectDocument_UploadedAt'])); ?></small>
                                            </div>
                                        </div>
                                        <a href="<?php echo htmlspecialchars($doc['ProjectDocument_FileLocation']); ?>" class="btn bg-color-primary text-white px-4 rounded-pill" download>
                                            <i class="bi bi-download me-2"></i>Download
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="tab-pane fade" id="gallery">
                                    <p class="text-muted mb-4">Visual documentation of project progress. Photos are uploaded by project engineers and administrators.</p>
                                    <div class="row g-4">
                                        <?php foreach ($milestones as $ms): ?>
                                        <div class="col-md-6">
                                            <div class="gallery-card shadow-sm h-100 bg-white">
                                                <img src="<?php echo htmlspecialchars($ms['projectMilestone_Image_Path']); ?>" class="gallery-img" alt="Milestone Photo">
                                                <div class="p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($ms['projectMilestone_Phase']); ?></h6>
                                                        <span class="badge rounded-pill" style="background-color: rgba(26, 54, 93, 0.1); color: var(--primary);">Ongoing</span>
                                                    </div>
                                                    <small class="text-muted">Uploaded: <?php echo date("Y-m-d", strtotime($ms['projectMilestone_UploadedAT'])); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="reports">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <p class="text-muted mb-0">Report issues and communicate with project administrators</p>
                                        <?php if(isset($_SESSION['user_ID'])): ?>
                                        <button class="btn bg-color-primary text-white" id="newReportBtn">
                                            <i class="bi bi-plus-circle me-2"></i>New Report
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div id="reportsList">
                                        <div class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-3 text-muted">Loading reports...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
    </main>

    <!-- Chat Interface (Sliding Panel) -->
    <div id="reportChatContainer">
        <div class="chat-header">
            <div>
                <h5 class="mb-0" id="chatTitle"></h5>
                <span id="chatStatus" class="badge"></span>
                <span id="statusControls"></span>
            </div>
            <button class="btn btn-link text-white p-0" id="closeChatBtn" style="font-size: 1.5rem;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <!-- Messages will be loaded here -->
        </div>
        
        <div class="chat-input">
            <textarea id="messageInput" rows="3" placeholder="Type your message... (Shift+Enter for new line)"></textarea>
            <button class="btn bg-color-primary text-white w-100" id="sendMessageBtn">
                <i class="bi bi-send me-2"></i>Send Message
            </button>
        </div>
    </div>

    <!-- New Report Modal -->
    <div class="modal fade" id="newReportModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-flag me-2"></i>Submit New Report
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="newReportForm">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Report Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="reportType" required>
                                <option value="">Select issue type...</option>
                                <option value="Safety Violation">Safety Violation</option>
                                <option value="Delay Issue">Delay Issue</option>
                                <option value="Quality Concern">Quality Concern</option>
                                <option value="Noise Complaint">Noise Complaint</option>
                                <option value="Traffic Disruption">Traffic Disruption</option>
                                <option value="Environmental Issue">Environmental Issue</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reportDescription" rows="4" 
                                placeholder="Please provide detailed information about the issue..." required></textarea>
                            <small class="text-muted">Be as specific as possible to help us address your concern</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Evidence (Optional)</label>
                            <input type="file" class="form-control" id="reportEvidence" 
                                accept="image/*,.pdf,.doc,.docx">
                            <small class="text-muted">Upload photos or documents (Max 5MB)</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn bg-color-primary text-white" id="submitReportBtn">
                        <i class="bi bi-send me-2"></i>Submit Report
                    </button>
                </div>
            </div>
        </div>
    </div>

        
        <?php
            include('../../components/footer.php');
        ?>



        <!-- Reusable Script -->
        <script src="/QTrace-Website/assets/js/map.js"></script>
        <script src="/QTrace-Website/assets/js/reportChat.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        
        <!-- Initialize Report System -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if(isset($project['Project_ID'])): ?>
                const projectID = <?php echo $project['Project_ID']; ?>;
                const userRole = '<?php echo $_SESSION['user_Role'] ?? 'guest'; ?>';
                initReportSystem(projectID, userRole);
                <?php endif; ?>
            });
        </script>
    </body>
</html>
