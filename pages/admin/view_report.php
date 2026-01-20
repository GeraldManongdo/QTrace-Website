<?php
    $page_name = 'reports';
    require('../../database/controllers/get_admin_view_report_details.php');
    include('../../database/connection/security.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Review report details and reply to users." />
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Report Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    <style>
        .main-card { border-radius: 12px; border: none; }
        .status-pill { border-radius: 50px; padding: 4px 12px; font-size: 0.85rem; font-weight: 500; }
        .icon-box { width: 40px; height: 40px; background: #eef2ff; color: #4f46e5; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .evidence-thumb { max-width: 100%; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08); }
        .comment-item { background: #f8f9fa; border-left: 4px solid #dee2e6; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
        .comment-item.admin-comment { border-left-color: #ffc107; background: #fff9e6; }
        .comment-item.user-comment { border-left-color: #0d6efd; background: #e7f1ff; }
    </style>
</head>
<body>
    <div class="app-container">
        <?php include('../../components/header.php'); ?>

        <div class="content-area">
            <?php include('../../components/sideNavigation.php'); ?>

            <main class="main-view">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="/QTrace-Website/pages/admin/reports.php">Report List</a></li>
                            <li class="breadcrumb-item active">Report Details</li>
                        </ol>
                    </nav>

                    <div class="row mb-2 p-2 align-items-center">
                        <div class="col">
                            <h2 class="fw-bold">Report Details</h2>
                            <p>View and manage report information</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Top Card - Basic Information -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3" style="width: 60px; height: 60px; font-size: 24px;">
                                            <i class="bi bi-flag-fill"></i>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-1">RPT-<?php echo str_pad($report['report_ID'], 3, '0', STR_PAD_LEFT); ?></h3>
                                            <p class="text-muted mb-0"><i class="bi bi-tag me-2"></i><?php echo htmlspecialchars($report['report_type'] ?? 'N/A'); ?></p>
                                        </div>
                                    </div>

                                    <div class="row g-4">

                                        <div class="col-md-3">
                                            <label class="text-muted d-block small mb-1">Reporter Name</label>
                                            <span class="fw-semibold"><?php echo htmlspecialchars(trim(($report['FirstName'] ?? '') . ' ' . ($report['LastName'] ?? ''))); ?></span>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted d-block small mb-1">Email</label>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($report['user_Email'] ?? 'N/A'); ?></span>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted d-block small mb-1">Project Name</label>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($report['ProjectDetails_Title'] ?? 'N/A'); ?></span>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="text-muted d-block small mb-1">Created Date</label>
                                            <span class="fw-semibold"><?php echo date('M d, Y h:i A', strtotime($report['report_CreatedAt'])); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Card - Report Details & Comments -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <!-- Evidence Image -->
                                    <?php if (!empty($report['report_evidencesPhoto_URL'])): ?>
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Evidence Photo</h6>
                                        <a href="<?php echo htmlspecialchars($report['report_evidencesPhoto_URL']); ?>" target="_blank">
                                            <img src="<?php echo htmlspecialchars($report['report_evidencesPhoto_URL']); ?>" alt="Evidence" class="evidence-thumb img-fluid">
                                        </a>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Report Description -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Report Description</h6>
                                        <div class="p-3 border rounded bg-light">
                                            <?php echo nl2br(htmlspecialchars($report['report_description'] ?? '')); ?>
                                        </div>
                                    </div>

                                    <!-- Admin Comments -->
                                    <?php if (count($messages) > 0): ?>
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Admin Comments (<?php echo count($messages); ?>)</h6>
                                        <?php foreach ($messages as $msg): 
                                            $isAdmin = strtolower($msg['user_Role']) === 'admin';
                                            $commentClass = $isAdmin ? 'admin-comment' : 'user-comment';
                                        ?>
                                        <div class="comment-item <?= $commentClass ?>">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <strong><?php echo htmlspecialchars(trim(($msg['FirstName'] ?? '') . ' ' . ($msg['LastName'] ?? ''))); ?></strong>
                                                    <?php if ($isAdmin): ?>
                                                        <span class="badge bg-danger ms-2">Admin</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary ms-2">Citizen</span>
                                                    <?php endif; ?>
                                                </div>
                                                <small class="text-muted"><?php echo date('M d, Y h:i A', strtotime($msg['report_CreatedAt'])); ?></small>
                                            </div>
                                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($msg['report_description'])); ?></p>
                                            <?php if (!empty($msg['report_evidencesPhoto_URL'])): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo htmlspecialchars($msg['report_evidencesPhoto_URL']); ?>" class="img-thumbnail" style="max-width: 200px;">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Add Comment & Status Update Form -->
                                    <div class="border-top pt-4">
                                        <form id="commentForm" method="POST" action="/QTrace-Website/database/controllers/report_response.php">
                                            <input type="hidden" name="report_id" value="<?= intval($report['report_ID']); ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="commentText" name="message" placeholder="Type your response to the reporter..." />
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select" id="reportStatus" name="status">
                                                        <option value="Sent" <?= $report['report_status'] == 'Sent' ? 'selected' : '' ?>>Sent</option>
                                                        <option value="Seen" <?= $report['report_status'] == 'Seen' ? 'selected' : '' ?>>Seen</option>
                                                        <option value="In Progress" <?= $report['report_status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                                        <option value="Resolved" <?= $report['report_status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn bg-color-primary text-white w-100">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>



    <?php include('../../components/toast.php'); ?>

    <script>
    </script>

    <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
    <script src="/QTrace-Website/assets/js/toast.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
