<?php 
  $current_page = 'addAccount'; 
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SEO -->
    <meta name="description" content="Register a new user in the QTRACE system."/>
    <meta name="author" content="Confractus" />
    <link rel="icon" type="image/png" sizes="16x16" href="" />
    <title>QTrace - Add New User</title>
    <!-- Bootstrap CSS Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- General Css Link -->
    <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
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
                  <a href="/QTrace-Website/dashboard">Home</a>
                </li>
                <li class="breadcrumb-item active">Add New User</li>
              </ol>
            </nav>
            <div class="row mb-2">
              <div class="col">
                <!-- Page Header -->
                <h2 class="fw-bold">Add New User</h2>
                <p>Register a new user in the QTRACE system</p>
              </div>
            </div>
          
            <!-- Form Section -->
            <div class="row g-3">
              <div class="col-12 card border-0 shadow-sm p-3">
                <form method="POST" action="/QTrace-Website/database/controllers/add_account.php" enctype="multipart/form-data" >
                  <div class="mb-4">
                    <legend>Personal Information</legend>
                    <hr class="m-1 mb-3" />
                    <div class="row mb-2">
                      <div class="col-md-4">
                        <label class="form-label fw-medium color-black" for="firstName">First Name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="e.g., John" required />
                      </div>
                      <div class="col-md-4">
                        <label class="form-label fw-medium color-black" for="middleName">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" placeholder="e.g., P."  />
                      </div>
                      <div class="col-md-4">
                        <label class="form-label fw-medium color-black" for="lastName">Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="e.g., De La Cruz" required />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-6">
                        <label class="form-label fw-medium color-black" for="sex">Sex</label>
                        <select class="form-select" aria-label="Default select example" name="sex" required>
                          <option selected>Select Sex</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-medium color-black" for="birthDate">BirthDate</label>
                        <input type="date" class="form-control" name="birth_date" placeholder="e.g., De La Cruz" required />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-12">
                        <label class="form-label fw-medium color-black" for="role">Role</label>
                        <select class="form-select" aria-label="Default select example" name="role" required>
                          <option selected>Select Role</option>
                          <option value="citizen">citizen</option>
                          <option value="admin">admin</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="mb-4">
                    <legend>Contact Information</legend>
                    <hr class="m-1 mb-3" />
                    <div class="row mb-2">
                      <div class="col-md-6">
                        <label class="form-label fw-medium color-black" for="contactNumber">Contact Number</label>
                        <input type="number" class="form-control" name="contact_number" placeholder="+639 9999 9999" required />
                      </div>
                      <div class="col-md-6">
                        <label for="validationDefaultEmail" class="form-label fw-medium color-black" >Email</label >
                        <div class="input-group">
                          <span class="input-group-text" id="inputGroupPrepend2">@</span>
                          <input type="email" class="form-control" name="email" id="validationDefaultEmail" aria-describedby="inputGroupPrepend2" placeholder="e.g., example@example.com" required />
                        </div>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-md-12">
                        <label for="validationDefault04" class="form-label fw-medium color-black" >Main Address</label>
                        <textarea class="form-control" name="main_address" rows="6" placeholder="Complete main address..." required></textarea>
                      </div>
                    </div>
                  </div>

                  

                  <div class="row mt-4 g-3">
                    <div class="col-6">
                      <button class="btn btn-outline-secondary w-100 fw-medium" type="reset">
                        Cancel
                      </button>
                    </div>
                    <div class="col-6">
                      <button class="btn bg-color-primary text-light w-100 fw-medium" type="submit">
                        Add
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
    
    <!-- Custome Script For This Page Only  --> 
    <script>

    </script>
         
    <!-- Reusable Script -->


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
