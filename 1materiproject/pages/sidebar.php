  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Muhammad Raihan Nafis</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php?halaman=dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <!-- BAGIAN ADMIN -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Data Admin
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahadmin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah Admin</p>
                </a>
              </li>              
            </ul>
          </li>

          <!-- BAGIAN kategori -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data kategori
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=kategori" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahkategori" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=kategoribermasalah" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>kategori Bermasalah</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- BAGIAN bantuan -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data bantuan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=bantuan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index bantuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahbantuan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah bantuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=bantuanbermasalah" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>bantuan Bermasalah</p>
                </a>
              </li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>