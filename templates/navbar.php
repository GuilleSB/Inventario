<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="menu-principal.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dropDown" aria-controls="dropDown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="dropDown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="bodega" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bodega
                </a>
                <div class="dropdown-menu" aria-labelledby="bodega">
                    <a class="dropdown-item" href="ingreso-bodega.php">Ingresar producto(s)</a>
                    <a class="dropdown-item" href="salida-bodega.php">Descontar producto(s)</a>
                    <a class="dropdown-item" href="lista-productos.php">Lista de productos</a>
                    <a class="dropdown-item" href="bitacora.php">Bitácora</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="administracion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administracion
                </a>
                <div class="dropdown-menu" aria-labelledby="administracion">
                    <a class="dropdown-item" href="nuevo-tipoProducto.php">Insertar tipo de producto</a>
                    <a class="dropdown-item" href="lista-tipos.php">Lista de tipos</a>
                </div>
            </li>
            <form class="form-inline" action="procesaDatos.php" method="POST">
                <input type="hidden" name="accion" value="logout">
                <input type="submit" class="btn btn-secondary" value="Cerrar sesión">
            </form>
            <style>
                @media(max-height:486px) {
                    .form-inline {margin-top:4px;}
                }
            </style>
        </ul>
    </div>

    </div>
</nav>