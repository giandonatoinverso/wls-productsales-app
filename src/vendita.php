<?php
require_once 'config/config.php';
require_once BASE_PATH . '/lib/Vendite/Vendite.php';
require_once BASE_PATH . '/lib/AuthManager/AuthManager.php';
session_start();

$vendite_instance = new Vendite();

if (!isset($_SESSION['auth_manager']))
    $_SESSION['auth_manager'] = new AuthManager();

if($_SERVER["REQUEST_METHOD"] === "GET") {
    $customRule = function ($input_scopes, $userScopes) {
        return array_intersect($input_scopes, $userScopes) !== [];
    };

    $_SESSION['auth_manager']->verifyScopes(["c_all_vendite", "c_self_vendite"], true, $customRule);
}

$edit = false;
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["edit"]) && $_GET["edit"] == "true" && isset($_GET["id_vendita"])) {
    $customRule = function ($input_scopes, $userScopes) {
        $requiredScopesSet1 = ["r_all_vendite", "u_all_vendite"];
        $requiredScopesSet2 = ["r_self_vendite", "u_self_vendite"];

        $containsSet1 = count(array_intersect($requiredScopesSet1, $userScopes)) === count($requiredScopesSet1);
        $containsSet2 = count(array_intersect($requiredScopesSet2, $userScopes)) === count($requiredScopesSet2);

        return $containsSet1 || $containsSet2;
    };

    $_SESSION['auth_manager']->verifyScopes(["r_all_vendite", "r_self_vendite", "u_all_vendite", "u_self_vendite"], true, $customRule);
    $edit = true;
    $vendita = $vendite_instance->getVendita($_GET["id_vendita"]);
}

if($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["del_id_vendita"])
) {
    $customRule = function ($input_scopes, $userScopes) {
        return array_intersect($input_scopes, $userScopes) !== [];
    };

    $_SESSION['auth_manager']->verifyScopes(["d_all_vendite", "d_self_vendite"], true, $customRule);
    $result = $vendite_instance->deleteVendita($_POST["del_id_vendita"]);
    if($result["httpCode"] == 200)
        $vendite_instance->success("Vendita cancellata correttamente");
}

if($_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["idCliente"]) &&
    isset($_POST["idVenditore"]) &&
    isset($_POST["idProdotto"]) &&
    isset($_POST["quantita"]) &&
    isset($_POST["importo"])
) {
    if(!isset($_POST["edit"])) {
        $customRule = function ($input_scopes, $userScopes) {
            return array_intersect($input_scopes, $userScopes) !== [];
        };

        $_SESSION['auth_manager']->verifyScopes(["c_all_vendite", "c_self_vendite"], true, $customRule);
        $result = $vendite_instance->addVendita($_POST);
        if ($result["httpCode"] == 200)
            $vendite_instance->success("Vendita inserita correttamente");
    } else {
        $customRule = function ($input_scopes, $userScopes) {
            return array_intersect($input_scopes, $userScopes) !== [];
        };

        $_SESSION['auth_manager']->verifyScopes(["u_all_vendite", "u_self_vendite"], true, $customRule);
        $result = $vendite_instance->editVendita($_POST);
        if ($result["httpCode"] == 200)
            $vendite_instance->success("Vendita modificata correttamente");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<title>Vendita</title>
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
                        <h1 class="m-0 text-dark">Vendita</h1>
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
                            <?php include BASE_PATH . '/forms/vendite_form.php'; ?>
                            <?php if($edit) { ?>
                                <input type="hidden" name="edit" value="true">
                                <input type="hidden" name="idVendita" value="<?php echo $vendita["id"];?>">
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
