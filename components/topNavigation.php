<nav class="navbar navbar-expand-lg navbar-dark bg-color-primary sticky-top shadow-sm py-3 fw-medium">
    <div class="container ">
      <a class="navbar-brand lh-1" href="#">
        <span class="fs-5">QTrace</span>
        <br>
        <span class="fs-8 fw-normal">Quezon City Transparency</span>
      </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-md-3 gap-sm-2 text-white">
              <li class="nav-item px-3 ">
                  <a class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>" href="/QTrace-Website/home">Home</a>
              </li>
              <li class="nav-item px-3">
                  <a class="nav-link <?php echo ($current_page == 'projects') ? 'active' : ''; ?>" href="/QTrace-Website/projects">Projects</a>
              </li>
              <li class="nav-item px-3">
                  <a class="nav-link <?php echo ($current_page == 'map') ? 'active' : ''; ?>" href="/QTrace-Website/map">Map</a>
              </li>
              <li class="nav-item px-3">
                  <a class="nav-link <?php echo ($current_page == 'contractor') ? 'active' : ''; ?>" href="/QTrace-Website/contractors">Contractors</a>
              </li>
              <li class="nav-item px-3">
                  <a class="nav-link <?php echo ($current_page == 'articles') ? 'active' : ''; ?>" href="/QTrace-Website/articles">Articles</a>
              </li>
              <li class="nav-item px-3">
                  <a class="nav-link <?php echo ($current_page == 'aboutUs') ? 'active' : ''; ?>" href="/QTrace-Website/about">About Us</a>
              </li>
            </ul>
        </div>
    </div>
</nav>