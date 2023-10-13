<fieldset>
    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <label for="username">ID cliente* </label>
                <div class="input-group">
                    <input type="number" name="idCliente" placeholder="ID cliente" class="form-control" required="required" value="<?php echo ($edit) ? $vendita['id_cliente'] : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">ID prodotto* </label>
                <div class="input-group">
                    <input type="number" name="idProdotto" placeholder="ID prodotto" class="form-control" required="required"
                           value="<?php
                                        $id_prodotto = 'a';
                                        if(isset($_GET["id_prodotto"]))
                                            $id_prodotto = $_GET["id_prodotto"];

                                            echo ($edit) ? $vendita['id_prodotto'] : $id_prodotto; ?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">ID venditore* </label>
                <div class="input-group">
                    <input type="number" name="idVenditore" placeholder="ID venditore" class="form-control" required="required" <?php if(!$_SESSION['auth_manager']->verifyScopes(["c_all_vendite"], false)) echo "readonly";?> value="<?php $userData = $_SESSION['auth_manager']->getUserData(); echo ($edit) ? $vendita['id_venditore'] : $userData[0]["id"]; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
            </div>
        </div>
    </div>

    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <label for="username">Quantita* </label>
                <div class="input-group">
                    <input type="number" name="quantita" placeholder="Quantita" class="form-control" required="required" value="<?php echo ($edit) ? $vendita['quantita'] : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">Importo* </label>
                <div class="input-group">
                    <input type="number" name="importo" placeholder="Importo" class="form-control" required="required" value="<?php echo ($edit) ? $vendita['importo'] : ''; ?>" autocomplete="off">
                </div>
            </div>
        </div>
    </div>


</fieldset>
