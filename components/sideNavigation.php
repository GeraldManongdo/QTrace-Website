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
            <a href="/QTrace-Website/dashboard" class="nav-link text-black  <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>">
                <i class="bi bi-house me-2"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-black d-flex justify-content-between align-items-center <?php echo ($page_name == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu1" 
            aria-expanded="<?php echo ($page_name == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-folder me-2"></i> Projects</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($page_name, ['projectList', 'projectMap', 'addProject', 'reports']) ? 'show' : ''; ?>" id="submenu1">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'projectList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/project-list">
                            Project List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'projectMap') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/project-map">
                            Project Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'addProject') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-project">
                            Add Project
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'reports') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/reports">
                            Reports
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-black d-flex justify-content-between align-items-center <?php echo ($page_name == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu2" 
            aria-expanded="<?php echo ($page_name == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-people"></i> Contactor</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($page_name, ['contractorList', 'addContractor']) ? 'show' : ''; ?>" id="submenu2">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'contractorList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/contractor-list">
                            Contractor List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'addContractor') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-contractor">
                            Add Contractor
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-black d-flex justify-content-between align-items-center <?php echo ($page_name == 'ongoing') ? '' : 'collapsed'; ?>" 
            data-bs-toggle="collapse" href="#submenu3" 
            aria-expanded="<?php echo ($page_name == 'ongoing') ? 'true' : 'false'; ?>">
                <span><i class="bi bi-person"></i> Accounts</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            
            <div class="collapse <?php echo in_array($page_name, ['accountList', 'addAccount']) ? 'show' : ''; ?>" id="submenu3">
                <ul class="nav nav-pills flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'accountList') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/account-list">
                            Account List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black <?php echo ($page_name == 'addAccount') ? 'active' : 'text-black-50'; ?>" href="/QTrace-Website/add-account">
                            Add Account
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        
        <li class="nav-item">
            <a href="/QTrace-Website/list-article" class="nav-link text-black <?php echo ($page_name == 'project_articles') ? 'active' : ''; ?>">
                <i class="bi bi-card-text"></i> Articles
            </a>
        </li>
        <li class="nav-item">
            <a href="/QTrace-Website/audit-list" class="nav-link text-black <?php echo ($page_name == 'audit') ? 'active' : ''; ?>">
                <i class="bi bi-archive"></i> Audit Logs
            </a>
        </li>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="/QTrace-Website/logout" class="btn w-100 d-flex text-black" >
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Logout
        </a>
    </div>
        </nav>
   

