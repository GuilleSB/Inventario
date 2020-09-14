<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Lista de productos</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>
    <div class="content container">
        <div class="row justify-content-center">
            <div class="col col-lg-10">
                <h4 class="subtitulo">
                    Todos los productos
                </h4>
                <table data-toggle="table" 
  data-pagination="true" data-search="true">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody class="lista-productos">
                        <?php
                        include './class/Producto.php';
                        $Productos = new Producto();

                        $resp = $Productos->ListaProductos();

                        for ($i = 0; $i < count($resp["productos"]); $i++) {
                            echo '<tr>';
                            echo '<td>' . $resp["productos"][$i]["Codigo"] . '</td>';
                            echo '<td>' . $resp["productos"][$i]["Tipo"] . '</td>';
                            echo '<td>' . $resp["productos"][$i]["Nombre"] . '</td>';
                            echo '<td>' . $resp["productos"][$i]["Descripcion"] . '</td>';
                            echo '<td>' . $resp["productos"][$i]["Cantidad"] . '</td>';
                            echo '<td><button val="' . $resp["productos"][$i]["Codigo"] . '" class="btn btn-warning">Modificar</button></td>';
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    <!--CONFIRMAR BORRAR PRODUCTO-->
    <div class="modal fade" id="confirmarBorrarProducto" tabindex="-1" role="dialog" aria-labelledby="confirmarBorrarProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="confirmarBorrarProductoTitle" style="color:white;">Confirmacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idProd" value="" />
                    ¿Seguro que desea borrar el producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                    <button type="button" class="btn btn-info" id="borrarProducto" data-dismiss="modal">SI</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL ERROR-->
    <div class="modal fade" id="errorEliminaProducto" tabindex="-1" role="dialog" aria-labelledby="errorEliminaProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorEliminaProductoTitle" style="color:white;">Error</h5>
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


    <!--MODAL ERROR EDITAR PRODUCTO-->
    <div class="modal fade" id="errorEditarProducto" tabindex="-1" role="dialog" aria-labelledby="errorEditarProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorEditarProductoTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al editar el producto
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL MODIFICADO CORRECTAMENTE-->
    <div class="modal fade" id="ModificaProducto" tabindex="-1" role="dialog" aria-labelledby="ModificaProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="ModificaProductoTitle" style="color:white;">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Producto modificado correctamente
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btn-recargar-pagina">Recargar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR PRODUCTO -->
    <div class="modal fade" id="EditarProducto" tabindex="-1" role="dialog" aria-labelledby="EditarProductoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditarProductoLabel">Editar producto: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="codigoproducto">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Código</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Vencimiento:</label>
                        <input type="date" class="form-control" id="fecha-vencimiento">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn-modificar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <?php include './templates/footer.php'; ?>
</body>

</html>