<?php 
    require('../../database/connection/connection.php');

    // 1. Get ID from URL and protect against basic injection
    $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($user_id > 0) {
        // 2. Fetch User Data
        $stmt = $conn->prepare("SELECT * FROM user_table WHERE user_ID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            die("User not found.");
        }

        // 3. Logic for Age Calculation
        $birthDate = new DateTime($user['user_birthDate']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } else {
        header("Location: account_list.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account - <?= htmlspecialchars($user['user_firstName']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="account_list.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <h3 class="fw-bold m-0">User Profile</h3>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                            <?= strtoupper(substr($user['user_firstName'], 0, 1) . substr($user['user_lastName'], 0, 1)) ?>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0 fw-bold"><?= htmlspecialchars($user['user_firstName'] . " " . $user['user_lastName']) ?></h4>
                            <span class="badge bg-info text-dark"><?= strtoupper($user['user_Role']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small fw-bold">Personal Details</h6>
                            <hr class="mt-1">
                            
                            <div class="mb-3">
                                <label class="text-muted d-block small">QC ID Number</label>
                                <span class="fw-medium text-primary"><?= htmlspecialchars($user['QC_ID_Number']) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted d-block small">Sex / Gender</label>
                                <span class="fw-medium"><?= ucfirst($user['user_sex']) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted d-block small">Birthdate</label>
                                <span class="fw-medium"><?= date("F d, Y", strtotime($user['user_birthDate'])) ?></span>
                                <span class="text-muted ms-2">(<?= $age ?> years old)</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small fw-bold">Contact Information</h6>
                            <hr class="mt-1">

                            <div class="mb-3">
                                <label class="text-muted d-block small">Email Address</label>
                                <span class="fw-medium"><?= htmlspecialchars($user['user_Email']) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted d-block small">Phone Number</label>
                                <span class="fw-medium"><?= htmlspecialchars($user['user_contactInformation']) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted d-block small">Home Address</label>
                                <span class="fw-medium"><?= nl2br(htmlspecialchars($user['user_address'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light text-end py-3">
                    <a href="edit_user.php?id=<?= $user['user_ID'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit Information
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>