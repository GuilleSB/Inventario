<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Registrarse</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <h5 style="color:white;text-align:center;">
            Inventario congregación guatuso <?php echo date("Y") ?>
        </h5>
    </nav>
    <!--BARRA DE NAVEGACION-->

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <h4 class="subtitulo">
                    Registrar nuevo usuario
                </h4>

                <form id="frmNuevoUsuario">
                    <div class="form-group row">
                        <label for="identificacion" class="col-md-2 col-form-label">Identificacion</label>
                        <div class="col-md-10">
                            <input type="text" id="identificacion" name="identificacion" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nombre" class="col-md-2 col-form-label">Nombre</label>
                        <div class="col-md-10">
                            <input type="text" id="nombre" name="nombre" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="apellidos" class="col-md-2 col-form-label">Apellidos</label>
                        <div class="col-md-10">
                            <input type="text" id="apellidos" name="apellidos" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="correo" class="col-md-2 col-form-label">Correo</label>
                        <div class="col-md-10">
                            <input type="email" id="correo" name="correo" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="telefono" class="col-md-2 col-form-label">Telefono</label>
                        <div class="col-md-10">
                            <input type="text" id="telefono" name="telefono" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="clave" class="col-md-2 col-form-label">Clave</label>
                        <div class="col-md-10">
                            <input type="password" id="clave" name="clave" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="clave2" class="col-md-2 col-form-label">Confirmar clave</label>
                        <div class="col-md-10">
                            <input type="password" id="clave2" name="clave2" class="form-control">
                        </div>
                    </div>

                    <input type="button" class="btn btn-primary" id="btnNuevoUsuario" value="Crear usuario">

                </form>
            </div>
        </div>
    </div>


    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="confirmaNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="confirmaNuevoUsuarioTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="confirmaNuevoUsuarioTitle" style="color:white;">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Se creó correctamente el nuevo usuario!
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
    <div class="modal fade" id="errorNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="errorNuevoUsuarioTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorNuevoUsuarioTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al crear nuevo usuario
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