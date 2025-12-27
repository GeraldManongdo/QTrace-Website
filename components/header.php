<style>
    /* Hero Section Background */
    .hero-section {
    background: linear-gradient(rgba(0, 51, 102, 0.85), rgba(0, 51, 102, 0.85)), 
                url("./assets/image/HeroBackground.jpg") no-repeat;
    background-size: cover;
    background-position: center;
    padding: 100px 0 120px 0;
    color: white;
}

    /* Badge Style */
    .badge-official {
        background-color: #FFD700;
        color: #003366;
        font-weight: 600;
        border-radius: 50px;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        font-size: 0.85rem;
    }

    /* Custom Search Bar */
    .search-wrapper {
        background: white;
        border-radius: 12px;
        padding: 8px;
        max-width: 600px;
        display: flex;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .search-wrapper input {
        border: none;
        padding: 12px 20px;
        flex-grow: 1;
        outline: none;
    }
    .search-wrapper .btn-search {
        background-color: #003366;
        color: white;
        border-radius: 8px;
        padding: 8px 25px;
        font-weight: 600;
    }

    /* Floating Stats Cards */
    .stats-container {
        margin-top: -60px; /* This creates the overlap effect */
    }
    .stat-card {
        border: none;
        border-radius: 15px;
        padding: 20px;
        height: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Specific Colors for Cards */
    .card-active { background-color: #f0fff4; }
    .card-completed { background-color: #f0f7ff; }
    .card-resolved { background-color: #fdf2ff; }
</style>

<header class="hero-section">
    <div class="container text-start">
        <div class="badge-official mb-4">
            <i class="bi bi-shield-check me-2"></i> Official Quezon City Platform
        </div>

        <h1 class="display-4 fw-bold mb-3">Transparency in Every Project</h1>
        
        <p class="lead mb-5 opacity-75" style="max-width: 650px;">
            Track government projects, monitor progress, and report issues. QTRACE empowers Quezon City citizens to see where public funds go and ensure accountability.
        </p>

        <div class="search-wrapper mb-5">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search for projects, barangays, or contractors...">
            <button class="btn btn-search">Search</button>
        </div>
    </div>
</header>

<section class="container stats-container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card card-active">
                <div>
                    <h2 class="fw-bold mb-0">3</h2>
                    <p class="text-muted small mb-0">Active Projects</p>
                </div>
                <div class="stat-icon bg-white text-success shadow-sm">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card card-completed">
                <div>
                    <h2 class="fw-bold mb-0">1</h2>
                    <p class="text-muted small mb-0">Completed Projects</p>
                </div>
                <div class="stat-icon bg-white text-primary shadow-sm">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card card-resolved">
                <div>
                    <h2 class="fw-bold mb-0">1</h2>
                    <p class="text-muted small mb-0">Resolved Citizen Reports</p>
                </div>
                <div class="stat-icon bg-white text-purple shadow-sm" style="color: #9f7aea;">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
            </div>
        </div>
    </div>
</section>