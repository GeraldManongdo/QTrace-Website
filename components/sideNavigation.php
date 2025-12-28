<style>
    /* Minimal CSS to ensure the sidebar behaves like a fixed column on Desktop */
    @media (min-width: 992px) {
        .offcanvas-lg {
            width: 280px;
            transform: none !important;
            visibility: visible !important;
            position: fixed;
            height: 100vh;
        }
        .main-content {
            margin-left: 280px;
        }
    }
</style>

<nav id="sidebarMenu" class="offcanvas-lg offcanvas-start navbar-dark bg-color-primary text-white d-flex flex-column p-3" tabindex="-1">
    
    <div class="offcanvas-header d-lg-none " >
        <h5 class="offcanvas-title text-white">Navigation</h5>
        <button type="button" class="btn-close btn-close-white " data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
    </div>

   <a class="navbar-brand lh-1" href="#">
        <span class="fs-5">QTrace</span>
        <br>
        <span class="fs-8 fw-normal">Quezon City Transparency</span>
      </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        
        <li class="nav-item">
            <a href="/Project/Qtrace/dashboard" class="nav-link text-white <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                <i class="bi bi-house me-2"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center <?php echo ($current_page == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu1" 
            aria-expanded="<?php echo ($current_page == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-folder me-2"></i> Projects</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($current_page, ['projectList', 'projectMap', 'addProject']) ? 'show' : ''; ?>" id="submenu1">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'projectList') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/project-list">
                            Project List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'projectMap') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/project-map">
                            Project Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'addProject') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/add-project">
                            Add Project
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center <?php echo ($current_page == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu2" 
            aria-expanded="<?php echo ($current_page == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-folder me-2"></i> Contactor</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($current_page, ['contractorList', 'addContractor', 'engineerList', 'addEngineer']) ? 'show' : ''; ?>" id="submenu2">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'contractorList') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/contractor-list">
                            Contractor List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'addContractor') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/add-contractor">
                            Add Contractor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'engineerList') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/engineer-list">
                            Engineer List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo ($current_page == 'addEngineer') ? 'active' : 'text-white-50'; ?>" href="/Project/Qtrace/add-engineer">
                            Add Engineer
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="/Project/Qtrace/history" class="nav-link text-white <?php echo ($current_page == 'history') ? 'active' : ''; ?>">
                <i class="bi bi-house me-2"></i> Audit Logs
            </a>
        </li>
        <li class="nav-item">
            <a href="/Project/Qtrace/reports" class="nav-link text-white <?php echo ($current_page == 'reports') ? 'active' : ''; ?>">
                <i class="bi bi-house me-2"></i> Reports
            </a>
        </li>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="btn w-100 d-flex align-items-center justify-content-center" >
            <i class="bi bi-box-arrow-in-right me-2"></i>
            <strong>Login</strong>
        </a>
    </div>
</nav>

   