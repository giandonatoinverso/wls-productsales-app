<?php

require_once './config/config.php';
require_once BASE_PATH . '/lib/Prodotti/Prodotti.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();

if (!isset($_SESSION['auth_manager']))
    $_SESSION['auth_manager'] = new AuthManager();

$prodotti_instance = new Prodotti();
$prodotti = $prodotti_instance->getProdotti();

?>

<!DOCTYPE html>
<html lang="en">
    <title>Wholesales client</title>
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
                                <h1 class="m-0 text-dark">Prodotti</h1>
                            </div><!-- /.col -->
                            <?php if ($_SESSION['auth_manager']->verifyScopes(["c_all_prodotti"], false)) {?>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item">
                                            <a href="prodotto.php" class="btn btn-success"><i class="fa fa-plus"></i> Aggiungi Prodotto</a>
                                        </li>
                                    </ol>
                                </div><!-- /.col -->
                            <?php } ?>
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
                            include BASE_PATH . '/forms/prodotti_table.php';
                            ?>

                   </div><!--/. container-fluid -->
                </section><!-- /.content -->

            </div><!-- /.content-wrapper -->
        

        <!-- Footer and scripts -->
        <?php include './includes/footer.php'; ?>
        <!-- /.Footer and scripts -->
    </body>
</html>
