<?php
require_once 'config/config.php';
require_once BASE_PATH . '/lib/Prodotti/Prodotti.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();

$prodotti_instance = new Prodotti();

if (!isset($_SESSION['auth_manager']))
    $_SESSION['auth_manager'] = new AuthManager();

if($_SERVER["REQUEST_METHOD"] === "GET") {
    $_SESSION['auth_manager']->verifyScopes(["c_all_prodotti"]);
}

$edit = false;
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["edit"]) && $_GET["edit"] == "true" && isset($_GET["id_prodotto"])) {
    $_SESSION['auth_manager']->verifyScopes(["r_all_prodotti", "u_all_prodotti"]);
    $edit = true;
    $prodotto = $prodotti_instance->getProdotto($_GET["id_prodotto"]);
}

if($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["del_id_prodotto"])
) {
    $_SESSION['auth_manager']->verifyScopes(["d_all_prodotti"]);
    $result = $prodotti_instance->deleteProdotto($_POST["del_id_prodotto"]);
    if($result["httpCode"] == 200)
        $prodotti_instance->success("Prodotto cancellato correttamente");
}

if($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["sku"]) &&
    isset($_POST["nome"]) &&
    isset($_POST["disponibilita"]) &&
    isset($_POST["prezzo"]) &&
    isset($_POST["fornitore"])
) {
    if(!isset($_POST["edit"])) {
        $_SESSION['auth_manager']->verifyScopes(["c_all_prodotti"]);
        $result = $prodotti_instance->addProdotto($_POST);
        if ($result["httpCode"] == 200)
            $prodotti_instance->success("Prodotto inserito correttamente");
    } else {
        $_SESSION['auth_manager']->verifyScopes(["u_all_prodotti"]);
        $result = $prodotti_instance->editProdotto($_POST);
        if ($result["httpCode"] == 200)
            $prodotti_instance->success("Prodotto modificato correttamente");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Prodotto</title>
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
                        <h1 class="m-0 text-dark">Prodotto</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Flash messages -->
                <?php include BASE_PATH.'/includes/flash_messages.php'; ?>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Inserisci i dati richiesti</h3>
                    </div>
                    <form class="well form-horizontal" action="" method="post" id="contact_form" enctype="multipart/form-data">
                        <div class="card-body">
                            <?php include BASE_PATH . '/forms/prodotti_form.php'; ?>
                            <?php if($edit) { ?>
                                <input type="hidden" name="edit" value="true">
                                <input type="hidden" name="idProdotto" value="<?php echo $prodotto["id"];?>">
                            <?php } ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Invia</button>
                        </div>
                    </form>
                </div>

            </div><!--/. container-fluid -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer and scripts -->
    <?php include './includes/footer.php'; ?>
</body>
</html>
