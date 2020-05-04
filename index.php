<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Iniciar sesión</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col col-md-6">

                <form id="frmLogin" name="frmLogin">
                    <h2>Inicia sesión</h2>

                    <div class="form-group">
                        <label for="correo">Email</label>
                        <input type="email" class="form-control" name="correo" id="correo" aria-describedby="correoHelp">
                        <small id="correoHelp" class="form-text text-muted">Digita el email que usaste para registrarte</small>
                    </div>
                    <div class="form-group">
                        <label for="clave">Clave</label>
                        <input type="password" class="form-control" name="clave" id="clave">
                    </div>

                    <button type="button" id="btnLogin" class="btn btn-primary">Ingresar</button>
                    <br><br>
                    <a href="registrarse.php">¿No tienes cuenta? Regístrate</a>
                </form>
            </div>
        </div>
    </div>


    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="errorLoginUsuario" tabindex="-1" role="dialog" aria-labelledby="errorLoginUsuarioTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorLoginUsuarioTitle" style="color:white;" >Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error, el usuario no está registrado
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>