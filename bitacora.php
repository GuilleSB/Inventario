<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bitácora</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>

    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <h4 class="subtitulo">
                   Entradas y salidas de productos
                </h4>

                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Responsable</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include './class/Producto.php';
                            $Producto = new Producto();

                            $resp = $Producto->Bitacora();

                            if ($resp["ok"]) {
                                for ($i = 0; $i < count($resp["productos"]); $i++) {
                                    if ($resp["productos"][$i]["TipoMOV"] == 1) {
                                        echo '<tr class="table-success">';
                                    } else {
                                        echo '<tr class="table-danger">';
                                    }
                                    echo '<td>' . $resp["productos"][$i]["FechaModifica"] . '</td>';
                                    echo '<td>' . $resp["productos"][$i]["Nombre"] . '</td>';
                                    echo '<td>' . $resp["productos"][$i]["Descripcion"] . '</td>';
                                    echo '<td>' . $resp["productos"][$i]["CantidadMOV"] . '</td>';
                                    echo '<td>' . $resp["productos"][$i]["Responsable"] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <?php include './templates/footer.php'; ?>
    <!--BARRA INFERIOR-->
</body>

</html>