<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lista de tipos</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <h4>
                    Tipos de producto
                </h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo de producto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include './class/TipoProducto.php';
                        $TipoProducto = new TipoProducto();

                        $resp = $TipoProducto->ListaTipoProducto();

                        if ($resp["ok"]) {
                            for ($i = 0; $i < count($resp["productos"]); $i++) {
                                echo '<tr>';
                                echo '<td>' . $resp["productos"][$i]["IdTipo"] . '</td>';
                                echo '<td>' . $resp["productos"][$i]["TipoProducto"] . '</td>';
                                echo '<td><button class="btn btn-danger btn-sm btn-block" id="btnEliminar" value="' . $resp["productos"][$i]["IdTipo"] . '">Eliminar</button></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <script>
                    $(function() {
                        $(document).on("click", "#btnEliminar", function() {
                            $("#idTipo").val($(this).val());
                            $("#confirmarBorrarTipo").modal("show");
                        });

                        $("#borrarTipo").click(function() {
                            $.ajax({
                                type: "post",
                                dataType: "json",
                                data: {
                                    "accion": "eliminar-tipoProducto",
                                    "idTipo": $("#idTipo").val()
                                },
                                url: "procesaDatos.php",
                                success: function(resp) {
                                    if (resp.ok) {
                                        location.reload();
                                    } else {
                                        $("#errorEliminaTipo").modal("show");
                                    }
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmarBorrarTipo" tabindex="-1" role="dialog" aria-labelledby="confirmarBorrarTipoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="confirmarBorrarTipoTitle" style="color:white;">Confirmacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idTipo" value="" />
                    ¿Seguro que desea borrar el tipo de producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="button" class="btn btn-info" id="borrarTipo" data-dismiss="modal">SI</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL ERROR-->
    <div class="modal fade" id="errorEliminaTipo" tabindex="-1" role="dialog" aria-labelledby="errorEliminaTipoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorEliminaTipoTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al eliminar producto
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <?php include './templates/footer.php'; ?>
    <!--BARRA INFERIOR-->
</body>

</html>