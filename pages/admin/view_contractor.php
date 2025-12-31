<?php
    require('../../database/controllers/get_view_contractor.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Contractor | <?= htmlspecialchars($contractor['Contractor_Name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .profile-header { background: #f8f9fa; border-bottom: 1px solid #dee2e6; padding: 40px 0; }
        .company-logo-lg { width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .doc-card:hover { background-color: #f1f8ff; transition: 0.3s; }
    </style>
</head>
<body class="bg-light">

<div class="profile-header mb-5">
    <div class="container">
        <div class="d-flex align-items-center">
            <img src="<?= !empty($contractor['Contractor_Logo_Path']) ? $contractor['Contractor_Logo_Path'] : 'https://via.placeholder.com/150' ?>" 
                 class="company-logo-lg rounded-3 me-4" alt="Company Logo">
            <div>
                <h1 class="fw-bold mb-1"><?= htmlspecialchars($contractor['Contractor_Name']) ?></h1>
                <p class="text-muted mb-0 fs-5"><i class="bi bi-person-badge me-2"></i><?= htmlspecialchars($contractor['Owner_Name']) ?></p>
                <div class="mt-2">
                    <span class="badge bg-primary px-3 py-2 rounded-pill"><?= $contractor['Years_Of_Experience'] ?> Years Experience</span>
                </div>
            </div>
            <div class="ms-auto">
                <a href="contractor_list.php" class="btn btn-outline-secondary">Back to List</a>
                <a href="edit_contractor.php?id=<?= $contractor_id ?>" class="btn btn-dark">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
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
                                    <?= htmlspecialchars($exp['expertise_name']) ?>
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
                                <a href="<?= $doc['file_path'] ?>" target="_blank" class="list-group-item list-group-item-action py-3 doc-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                            <span class="fw-bold"><?= htmlspecialchars($doc['document_name']) ?></span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>