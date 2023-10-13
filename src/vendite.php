<?php

require_once './config/config.php';
require_once BASE_PATH . '/lib/Vendite/Vendite.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();

if (!isset($_SESSION['auth_manager']))
    $_SESSION['auth_manager'] = new AuthManager();

$customRule = function ($input_scopes, $userScopes) {
    return array_intersect($input_scopes, $userScopes) !== [];
};

$_SESSION['auth_manager']->verifyScopes(["r_all_vendite", "r_self_vendite"], true, $customRule);

$vendite_instance = new Vendite();
$vendite = $vendite_instance->getVendite();

?>

<!DOCTYPE html>
<html lang="en">
    <title>Wholesales client - vendite</title>
    <head>
    <?php include './includes/head.php'; ?>
    </head>
    
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php include './includes/navbar.php'; ?>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <?php include './includes/sidebar.php'; ?>
            <!-- /.Main Sidebar Container -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Vendite</h1>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div><!-- /.content-header -->

                <!-- Flash message-->
                <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
                <!-- /.Flash message-->

                <!-- Main content -->
                <section class="content">
                   <div class="container-fluid">

                            <?php
                            include BASE_PATH . '/forms/vendite_table.php';
                            ?>

                   </div><!--/. container-fluid -->
                </section><!-- /.content -->

            </div><!-- /.content-wrapper -->
        

        <!-- Footer and scripts -->
        <?php include './includes/footer.php'; ?>
        <!-- /.Footer and scripts -->
    </body>
</html>
