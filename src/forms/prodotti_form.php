<fieldset>
    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <label for="username">Sku* </label>
                <div class="input-group">
                    <input type="text" name="sku" placeholder="Sku" class="form-control" required="required" value="<?php echo ($edit) ? $prodotto['sku'] : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">Nome* </label>
                <div class="input-group">
                    <input type="text" name="nome" placeholder="Nome" class="form-control" required="required" value="<?php echo ($edit) ? $prodotto['nome'] : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">Disponibilita* </label>
                <div class="input-group">
                    <input type="number" name="disponibilita" placeholder="Disponibilita" class="form-control" required="required" value="<?php echo ($edit) ? $prodotto['disponibilita'] : ''; ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 col-md-3">
                <label for="username">Prezzo* </label>
                <div class="input-group">
                    <input type="number" name="prezzo" placeholder="Prezzo" class="form-control" required="required" value="<?php echo ($edit) ? $prodotto['prezzo'] : ''; ?>" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <label for="username">Fornitore* </label>
                <div class="input-group">
                    <input type="text" name="fornitore" placeholder="Fornitore" class="form-control" required="required" value="<?php echo ($edit) ? $prodotto['fornitore'] : ''; ?>" autocomplete="off">
                </div>
            </div>
        </div>
    </div>


</fieldset>
