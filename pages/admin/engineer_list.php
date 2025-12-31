<?php 
    $current_page = 'engineerList'; 
    require('../../database/controllers/get_contractor.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--  -->
    <meta name="description" content="QTrace is the official Quezon City Transparency Platform, enabling citizens to track government projects, monitor progress, and report issues for greater accountability."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Quezon City Transparency Platform</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/Project/Qtrace/assets/css/styles.css" />
    <!-- Custome Css For This Page Only  -->
    <style>

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
                            <a href="/Project/Qtrace/dashboard">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Engineer List</li>
                        </ol>
                    </nav>

                    <div class="row mb-2">
                        <div class="col">
                            <!-- Page Header -->
                            <h2 class="fw-bold">Engineer List</h2>
                            <p>Official list of verified engineers working on Quezon City government projects</p>
                        </div>
                    </div>
                    
                    <!-- Filter Form -->
                    <div class="row g-3">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <form method="GET" class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold">Filter by Skill</label>
                                        <input type="text" name="skill" class="form-control" placeholder="e.g. Plumbing, Electrical" value="<?= $search_skill ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Min. Experience (Years)</label>
                                        <input type="number" name="min_years" class="form-control" placeholder="0" value="<?= $min_years > 0 ? $min_years : '' ?>">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
                                        <a href="list_contractors.php" class="btn btn-link">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Engineer List Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company</th>
                                            <th>Representative</th>
                                            <th>Contact</th>
                                            <th>Expertise</th>
                                            <th>Exp.</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if($row['Contractor_Logo_Path']): ?>
                                                            <img src="/Project/Qtrace/uploads/logos/<?= $row['Contractor_Logo_Path'] ?>" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px; height:40px;">
                                                                <?= substr($row['Contractor_Name'], 0, 1) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <span class="fw-bold"><?= htmlspecialchars($row['Contractor_Name']) ?></span>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($row['Owner_Name']) ?></td>
                                                <td>
                                                    <small class="d-block"><?= htmlspecialchars($row['Company_Email_Address']) ?></small>
                                                    <small class="text-muted"><?= htmlspecialchars($row['Contact_Number']) ?></small>
                                                </td>
                                                <td>
                                                    <?php 
                                                    $skills = explode(', ', $row['skills']);
                                                    foreach($skills as $skill) {
                                                        echo '<span class="badge bg-info text-dark me-1">' . htmlspecialchars($skill) . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><span class="badge bg-secondary"><?= $row['Years_Of_Experience'] ?> yrs</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="view_contractor.php?id=<?= $row['Contractor_Id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $row['Contractor_Id'] ?>)"><i class="bi bi-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">No contractors found matching your criteria.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Custome Script For This Page Only  --> 
        <script>

        </script>
         
        <!-- Reusable Script -->
        <script src=""></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
