
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!--<div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-cog"></i> Settings
          </a>
          <div class="dropdown-divider"></div>-->
            <?php if(isset($_COOKIE['refreshToken']) && isset($_COOKIE['refreshTokenExpiration']) && isset($_COOKIE['userData']) && isset($_COOKIE['scopes'])) { ?>
              <a href="./logout.php" class="dropdown-item">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            <?php } else { ?>
                <a href="./login.php" class="dropdown-item">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            <?php } ?>
        </div>
      </li>
    </ul>
  </nav>