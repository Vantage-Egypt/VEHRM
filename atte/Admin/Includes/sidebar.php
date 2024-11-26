<?php
$fullName = ""; 
if (isset($_SESSION['userId'])) {
    $userId = $conn->real_escape_string($_SESSION['userId']);

    $query = "SELECT * FROM tbladmin WHERE Id = $userId";

    $rs = $conn->query($query);

    if ($rs) {
        $num = $rs->num_rows;

        if ($num > 0) {
            $row = $rs->fetch_assoc();

            $fullName = $row['firstName'] . " " . $row['lastName'];
            
                } else {
            echo "Admin not found";
        }
    } else {
        echo "Error: " . $conn->error;
    }
} else {
 header('location: ../index.php');
}


?>
 
 <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed; top: 55px;">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="../Adm/dist/img/ve-logo-icon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">VE HRM System</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <!-- <img src="../Adm/dist/img/userimg.png" class="img-circle elevation-2" alt="User Image"> -->
          </div>
          <div class="info">
            
            <a href="#" class="d-block">Welcome,  <?php echo $fullName; ?></a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="../Admin/index.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            
            <!-- CompanyStructure-->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>
                  CompanyStructure
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="companyStructure.php" class="nav-link">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <p>Companies</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Departments</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-users-slash nav-icon"></i>
                    <p>Branches</p>
                  </a>
                </li>

              </ul>
            </li>
            <!-- / CompanyStructure -->
            <!-- EMPLOYYES-->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Manage Employees
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="createEmployee.php" class="nav-link">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <p>Add Employees</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="createUsers.php" class="nav-link">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <p>Add Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-users-slash nav-icon"></i>
                    <p>Archived Employees</p>
                  </a>
                </li>

              </ul>
            </li>
            <!-- / EMPLOYEES -->
          

            <!--  Attendance -->
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-stopwatch"></i>
                <p>
                  Manage Attendances
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-fingerprint nav-icon"></i>
                    <p>Finger Attendence</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-camera nav-icon"></i>
                    <p>Face Attendance</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-users-slash nav-icon"></i>
                    <p>View Attendance</p>
                  </a>
                </li>

              </ul>
            </li>
            <!--/  Attendance -->
  
            <li class="nav-header">LABELS</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Important</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Warning</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Informational</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
