<?php 
    require('../../database/controllers/get_view_contractor.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit | <?= htmlspecialchars($contractor['Contractor_Name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="contractor_list.php">Contractors</a></li>
                    <li class="breadcrumb-item"><a href="view_contractor.php?id=<?= $contractor_id ?>"><?= htmlspecialchars($contractor['Contractor_Name']) ?></a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>

            <form action="../../database/controllers/update_contractor.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $contractor_id ?>">

                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-primary">Edit Contractor Profile</h5>
                        <div>
                            <a href="view_contractor.php?id=<?= $contractor_id ?>" class="btn btn-light border btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Save Changes</button>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">General Information</h6>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Contractor/Company Name</label>
                                <input type="text" name="contractor_name" class="form-control" 
                                       value="<?= htmlspecialchars($contractor['Contractor_Name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Owner Name</label>
                                <input type="text" name="owner_name" class="form-control" 
                                       value="<?= htmlspecialchars($contractor['Owner_Name']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-medium">Experience (Years)</label>
                                <input type="number" name="experience" class="form-control" 
                                       value="<?= $contractor['Years_Of_Experience'] ?>">
                            </div>

                            <div class="col-md-12 mt-5">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Contact Details</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email Address</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($contractor['Company_Email_Address']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium">Contact Number</label>
                                <input type="text" name="phone" class="form-control" 
                                       value="<?= htmlspecialchars($contractor['Contact_Number']) ?>" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-medium">Business Address</label>
                                <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($contractor['Company_Address']) ?></textarea>
                            </div>

                            <div class="col-md-12 mt-5">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Additional Information</h6>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-medium">Notes</label>
                                <textarea name="notes" class="form-control" rows="4" placeholder="Enter any internal notes..."><?= htmlspecialchars($contractor['Additional_Notes']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light p-3 text-end">
                        <button type="submit" class="btn btn-primary px-5">Update Contractor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>