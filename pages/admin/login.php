<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QTRACE Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">

<div class="container">
    <div class="row g-0 shadow rounded-4 overflow-hidden bg-white mx-auto" style="max-width: 1000px;">
        
        <div class="col-lg-5 bg-primary text-white p-5 d-flex flex-column justify-content-center">
            <div class="bg-warning text-primary rounded-circle d-flex align-items-center justify-content-center mb-4 fw-bold" style="width: 60px; height: 60px;">QC</div>
            <h1 class="h2 fw-bold mb-3">Welcome to QTRACE</h1>
            <p class="mb-5 opacity-75">Sign in to access your personalized dashboard and track projects.</p>
            
            <div class="d-flex mb-3">
                <i class="bi bi-shield-check me-3 fs-4"></i>
                <div><h6 class="mb-0 fw-bold">Secure Access</h6><small class="opacity-75">Government-grade security</small></div>
            </div>
        </div>

        <div class="col-lg-7 p-5">
            <h3 class="fw-bold mb-4 text-primary">Admin Login</h3>

            <!-- <?php if ($error): ?>
                <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'expired'): ?>
                <div class="alert alert-warning py-2 small">Session expired. Please log in again.</div>
            <?php endif; ?> -->

            <form method="POST" action="/QTrace-Website/database/controllers/login_action.php">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Admin Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="number" name="QC_ID_Number" class="form-control bg-light border-start-0" placeholder="admin@quezoncity.gov.ph" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" name="user_Password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Sign In</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>