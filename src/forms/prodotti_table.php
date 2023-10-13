<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="3%">ID</th>
                        <th width="12%">Sku</th>
                        <th width="22%">Nome</th>
                        <th width="10%">Disponibilita</th>
                        <th width="10%">Prezzo</th>
                        <th width="10%">Fornitore</th>
                        <?php
                        $customRule = function ($input_scopes, $userScopes) {
                            return array_intersect($input_scopes, $userScopes) !== [];
                        };

                        if($_SESSION['auth_manager']->verifyScopes(["c_all_vendite", "c_self_vendite"], false, $customRule)):
                        ?>
                            <th width="14%">Operazioni</th>
                        <?php endif ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($prodotti as $prodotto):
                    ?>
                        <tr>
                            <td><?php echo $prodotto["id"];?></td>
                            <td><?php echo $prodotto["sku"];?></td>
                            <td><?php echo $prodotto["nome"];?></td>
                            <td><?php echo $prodotto["disponibilita"];?> pz</td>
                            <td>€ <?php echo $prodotto["prezzo"];?></td>
                            <td><?php echo $prodotto["fornitore"];?></td>
                            <?php
                                $customRule = function ($input_scopes, $userScopes) {
                                    return array_intersect($input_scopes, $userScopes) !== [];
                                };

                                if($_SESSION['auth_manager']->verifyScopes(["c_all_vendite", "c_self_vendite"], false, $customRule)):
                            ?>
                                <td>
                                    <!-- VENDITA  -->
                                    <a href="vendita.php?id_prodotto=<?php echo $prodotto["id"];?>" class="btn btn-primary"><i class="fas fa-shopping-cart"></i></a>

                                    <?php if ($_SESSION['auth_manager']->verifyScopes(["u_all_prodotti"], false)) :?>
                                    <!-- EDIT -->
                                    <a href="prodotto.php?edit=true&id_prodotto=<?php echo $prodotto["id"];?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <?php endif ?>

                                    <?php if ($_SESSION['auth_manager']->verifyScopes(["d_all_prodotti"], false)) :?>
                                    <!-- DELETE -->
                                    <a
                                                class="btn btn-danger delete_btn"
                                                id="delete-button"
                                                data-toggle="modal"
                                                data-target="#delete-modal"
                                                data-del_id_prodotto="<?php echo $prodotto["id"];?>"
                                    ><i class="fas fa-trash"></i></a>
                                    <?php endif ?>
                                </td>
                            <?php endif ?>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div><!-- /.Card body -->

            <div class="card-footer clearfix">
            </div><!-- /.Card footer -->

        </div><!-- /.Card -->
    </div><!-- /.col -->
</div><!-- /.row -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delete-modal" role="dialog">
    <div class="modal-dialog">
        <form action="prodotto.php" method="POST">
            <!-- Modal content -->

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Conferma</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_id_prodotto" id="del_id_prodotto" value="">
                    <p>
                        Sei sicuro di voler cancellare il prodotto?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salva</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- //Delete Confirmation Modal -->

<script>
    const deleteButton = document.querySelector('#delete-button');

    deleteButton.addEventListener('click', function () {
        document.getElementById('del_id_prodotto').value = deleteButton.getAttribute('data-del_id_prodotto');

        const deleteModal = document.querySelector('#delete-modal');
        deleteModal.style.display = 'block';
    });
</script>