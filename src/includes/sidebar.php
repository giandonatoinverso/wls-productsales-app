
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <?php
        if (isset($_SESSION['auth_manager']))
            $userData = $_SESSION['auth_manager']->getUserData();

        if(isset($userData[0]["nome"]) && isset($userData[0]["cognome"])) {
            ?>
              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                  <img src="dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a href="#" class="d-block"><?php echo $userData[0]["nome"] . " " . $userData[0]["cognome"]; ?></a>
                    <span style="font-size: 13px; color: white">ID: <?php echo $userData[0]["id"]; ?></span>
                </div>
              </div>
        <?php } ?>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="./index.php" <?php echo (substr(CURRENT_PAGE, 0, 9) == 'index.php' || CURRENT_PAGE == '' || (substr(CURRENT_PAGE, 0, 12) == 'prodotto.php')) ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
             <i class="nav-icon fas fa-shopping-cart"></i>
             <p>
               Prodotti
             </p>
           </a>
         </li>

            <?php
            $customRule = function ($input_scopes, $userScopes) {
                return array_intersect($input_scopes, $userScopes) !== [];
            };

            if($_SESSION['auth_manager']->verifyScopes(["r_all_vendite", "r_self_vendite"], false, $customRule)) {?>

                <li class="nav-item">
                    <a href="./vendite.php" <?php echo (substr(CURRENT_PAGE, 0, 11) == 'vendite.php' || substr(CURRENT_PAGE, 0, 11) == 'vendita.php') ? ' class="nav-link active"' : ' class="nav-link"'; ?>>
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>Vendite</p>
                    </a>
                </li>

            <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>