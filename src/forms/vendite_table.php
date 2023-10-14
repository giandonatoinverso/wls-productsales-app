<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="3%">ID</th>
                        <th width="10%">ID cliente</th>
                        <th width="10%">ID Venditore</th>
                        <th width="10%">ID Prodotto</th>
                        <th width="10%">Quantita</th>
                        <th width="10%">Importo</th>
                        <th width="14%">Data vendita</th>
                        <th width="14%">Operazioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($vendite as $vendita):
                    ?>
                        <tr>
                            <td><?php echo $vendita["id"];?></td>
                            <td><?php echo $vendita["id_cliente"];?></td>
                            <td><?php echo $vendita["id_venditore"];?></td>
                            <td><?php echo $vendita["id_prodotto"];?></td>
                            <td><?php echo $vendita["quantita"];?> pz</td>
                            <td>€ <?php echo $vendita["importo"];?></td>
                            <td><?php $data = new DateTime($vendita["data_vendita"]); echo $data->format('d-m-Y H:i:s')?></td>
                            <td>
                                <!-- Visualizza  -->
                                <a href="#" class="btn btn-primary"><i class="fas fa-info-circle"></i></a>

                                <!-- EDIT -->
                                <?php
                                $customRule = function ($input_scopes, $userScopes) {
                                $requiredScopesSet1 = ["r_all_vendite", "u_all_vendite"];
                                $requiredScopesSet2 = ["r_self_vendite", "u_self_vendite"];

                                $containsSet1 = count(array_intersect($requiredScopesSet1, $userScopes)) === count($requiredScopesSet1);
                                $containsSet2 = count(array_intersect($requiredScopesSet2, $userScopes)) === count($requiredScopesSet2);

                                return $containsSet1 || $containsSet2;
                                };

                                if($_SESSION['auth_manager']->verifyScopes(["r_all_vendite", "r_self_vendite", "u_all_vendite", "u_self_vendite"], false, $customRule)):?>
                                    <a href="vendita.php?edit=true&id_vendita=<?php echo $vendita["id"];?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <?php endif ?>

                                <!-- DELETE -->
                                <?php
                                $customRule = function ($input_scopes, $userScopes) {
                                    return array_intersect($input_scopes, $userScopes) !== [];
                                };

                                if($_SESSION['auth_manager']->verifyScopes(["d_all_vendite", "d_self_vendite"], false, $customRule)):
                                ?>
                                    <a
                                            class="btn btn-danger delete_btn"
                                            data-toggle="modal"
                                            data-target="#delete-modal"
                                            data-del_id_vendita="<?php echo $vendita["id"];?>"
                                    ><i class="fas fa-trash"></i></a>
                                <?php endif ?>
                            </td>
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
        <form action="vendita.php" method="POST">
            <!-- Modal content -->

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Conferma</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_id_vendita" id="del_id_vendita" value="">
                    <p>
                        Sei sicuro di voler cancellare la vendita?
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
    const deleteButtons = document.querySelectorAll('.delete_btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('del_id_vendita').value = button.getAttribute('data-del_id_vendita');

            const deleteModal = document.querySelector('#delete-modal');
            deleteModal.style.display = 'block';
        });
    });
</script>