<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Ingresar producto</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>
    <div class="container content">

        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <h4 class="subtitulo">Nuevo producto</h4>
                <form id="frmNuevoProducto">
                    <div class="form-group row">
                        <label for="tipo" class="col-sm-2 col-form-label">Tipo de producto</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="">Seleccione una opción...</option>
                                <?php
                                include './class/TipoProducto.php';
                                $TipoProducto = new TipoProducto();
                                $tipoProducto = $TipoProducto->ListaTipoProducto();
                                $prod = $tipoProducto["productos"];
                                for ($i = 0; $i < count($prod); $i++) {
                                    echo '<option value="' . $prod[$i]["IdTipo"] . '-' . $prod[$i]["UnidadMedida"] . '">' . $prod[$i]["TipoProducto"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label">Descripcion</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fechaVencimiento" class="col-sm-2 col-form-label">Vencimiento</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" required>
                        </div>
                    </div>

                    <input type="button" id="btnNuevoProducto" class="btn btn-primary" value="Guardar" />

                </form>
            </div>
        </div>
    </div>

    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="confirmaNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="confirmaNuevoProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="confirmaNuevoProductoTitle" style="color:white;">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Se creó correctamente el nuevo producto!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btnReload" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $(".btnReload").click(function(){
                location.reload();
            });
        });
    </script>

    <!--MODAL ERROR-->
    <div class="modal fade" id="errorNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="errorNuevoProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorNuevoProductoTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al crear nuevo producto
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <?php include './templates/footer.php'; ?>
</body>

</html>