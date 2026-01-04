<style>
/* Sidebar Styling */
.sidebar {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    transition: all 0.3s;
    color: var(--text-dark) !important;
}

@media (max-width: 991.98px) {
    .sidebar { width: 0; } /* Handled by Offcanvas on Mobile */
}

@media (min-width: 992px) {
    .sidebar-offcanvas {
        transform: none !important;
        visibility: visible !important;
        position: relative !important;
        height: 100% !important;
        width: 280px !important;
    }
}


</style>

<nav id="sidebarMenu" class="sidebar sidebar-offcanvas offcanvas-lg offcanvas-start navbar-dark   d-flex flex-column p-3 shadow-sm " tabindex="-1">

            <div class="offcanvas-header d-lg-none px-0">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"></button>
            </div>

            <div class="d-lg-none mb-4 mt-2">
                <div class="input-group">
                    <span class="input-group-text bg-secondary border-0 text-black"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-secondary border-0 text-black" placeholder="Search...">
                </div>
            </div>

    <ul class="nav nav-pills flex-column mb-auto">
        
        <li class="nav-item">
            <a href="/QTrace-Website/dashboard" class="nav-link text-black  <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                <i class="bi bi-house me-2"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-black d-flex justify-content-between align-items-center <?php echo ($current_page == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu1" 
            aria-expanded="<?php echo ($current_page == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-folder me-2"></i> Projects</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($current_page, ['projectList', 'projectMap', 'addProject']) ? 'show' : ''; ?>" id="submenu1">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'projectList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/project-list">
                            Project List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'projectMap') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/project-map">
                            Project Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'addProject') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-project">
                            Add Project
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-black d-flex justify-content-between align-items-center <?php echo ($current_page == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu2" 
            aria-expanded="<?php echo ($current_page == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-people"></i> Contactor</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($current_page, ['contractorList', 'addContractor', 'engineerList', 'addEngineer']) ? 'show' : ''; ?>" id="submenu2">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'contractorList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/contractor-list">
                            Contractor List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'addContractor') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-contractor">
                            Add Contractor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'engineerList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/engineer-list">
                            Engineer List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($current_page == 'addEngineer') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-engineer">
                            Add Engineer
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="/QTrace-Website/history" class="nav-link text-black <?php echo ($current_page == 'history') ? 'active' : ''; ?>">
                <i class="bi bi-archive"></i> Audit Logs
            </a>
        </li>
        <li class="nav-item">
            <a href="/QTrace-Website/reports" class="nav-link text-black <?php echo ($current_page == 'reports') ? 'active' : ''; ?>">
                <i class="bi bi-card-text"></i> Reports
            </a>
        </li>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="btn w-100 d-flex text-black" >
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Login
        </a>
    </div>
        </nav>
   