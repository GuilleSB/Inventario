<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Ingresar tipo de producto</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col col-md-8">
                <h4 class="subtitulo">Nuevo tipo de producto</h4>

                <form>
                    <div class="form-group row">
                        <label for="tipoProducto" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tipoProducto">
                        </div>
                    </div>
                    
                    <input type="button" id="btnNuevoTipoProducto" class="btn btn-primary" value="Guardar" />
                </form>
            </div>
        </div>
    </div>

    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="confirmaNuevoTipo" tabindex="-1" role="dialog" aria-labelledby="confirmaNuevoTipoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="confirmaNuevoTipoTitle" style="color:white;" >Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Se creó correctamente el nuevo tipo de producto!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="errorNuevoTipo" tabindex="-1" role="dialog" aria-labelledby="errorNuevoTipoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorNuevoTipoTitle" style="color:white;" >Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al crear nuevo tipo de producto
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