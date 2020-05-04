<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Menú principal</title>
  <?php include './referencias.php' ?>
</head>

<body>
  <?php include './templates/navbar.php'; ?>

  <div class="container content">
    <div class="row justify-content-center" style="margin-bottom:15px;">

      <div class="col-sm-10">
        <h3 class="sub-principal">Menu principal</h3>
        <p class="p-principal">
          Bienvenido al inventario de la congregación patarrá. El presente sistema posee funciones limitadas de guardar
          y consultar productos ingresados. Si tiene algún problema contacte al administrador del sistema (guillesotoblanco@gmail.com).
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-sm-5">
        <h4 class="sub-secundario">Menu bitacora</h4>
        <p class="p-principal">
          Podrá ingresar nuevos productos, registrar salidas de productos, ver el inventario actual y seguir el histórico de movimientos de productos
        </p>
      </div>
      <div class="col-sm-5">
        <h4 class="sub-secundario">Menu Administracion</h4>
        <p class="p-principal">
          Podrá ingresar tipos de productos y ver una lista de ellos
        </p>
      </div>
    </div>
  </div>
  <?php include './templates/footer.php'; ?>
</body>

</html>