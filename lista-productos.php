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
                <div class="form-group row">
                    <label for="tipo" class="col-sm-1 col-form-label">Filtros: </label>
                    <div class="col-sm-3">
                        <select class="form-control" id="filtro">
                            <option>Seleccione un filtro... </option>
                            <option>Tipo</option>
                            <option>Nombre</option>
                            <option>Descripcion</option>
                            <option>Vencimientos proximos</option>
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="txtFiltro" disabled />
                    </div>
                </div>



                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Tipo</th>
                                <th style="text-align:center;">Nombre</th>
                                <th style="text-align:center;">Descripcion</th>
                                <th style="text-align:center;">Cantidad</th>
                                <th style="text-align:center;">Vencimiento</th>
                                <th style="text-align:center;">Accion</th>
                            </tr>
                        </thead>
                        <tbody class="lista-productos">
                            <script>
                                var productosArray = [];
                                $(function() {

                                    $.ajax({
                                        dataType: "json",
                                        type: "post",
                                        data: {
                                            "accion": "lista-productos"
                                        },
                                        url: "procesaDatos.php",
                                        success: function(resp) {
                                            for (var i = 0; i < resp.productos.length; i++) {
                                                productosArray.push(
                                                    resp.productos[i]
                                                );
                                            }
                                            RecargarTabla2(productosArray);
                                        }
                                    });

                                    function RecargarTabla2(prod) {
                                        for (var i = 0; prod.length; i++) {
                                            $(".lista-productos").append(
                                                '<tr>' +
                                                '<td style="vertical-align:middle;text-align:center;">' + prod[i].TipoProducto + '</td>' +
                                                '<td style="vertical-align:middle;text-align:center;" id="nom' + prod[i].IdProducto + '">' + prod[i].Nombre + '</td>' +
                                                '<td style="vertical-align:middle;text-align:center;" id="des' + prod[i].IdProducto + '">' + prod[i].Descripcion + '</td>' +
                                                '<td style="vertical-align:middle;text-align:center;">' + prod[i].Cantidad + '</td>' +
                                                '<td style="vertical-align:middle;text-align:center;">' + prod[i].FechaVencimiento + '</td>' +
                                                '<td><button class="btn btn-danger btn-sm btn-block" id="btnEliminar" value="'+ prod[i].IdProducto + '">Eliminar</button></td>' +
                                                '</tr>'
                                            );
                                        }
                                    }

                                    $(document).on("click","#btnEliminar",function(){
                                        $("#idProd").val($(this).val());
                                        $("#confirmarBorrarProducto").modal("show");
                                    });

                                    $("#borrarProducto").click(function(){
                                        $.ajax({
                                            type:"post",
                                            dataType:"json",
                                            data:{
                                                "accion":"eliminar-producto",
                                                "IdProducto" : $("#idProd").val()
                                            },
                                            url : "procesaDatos.php",
                                            success: function(resp){
                                                if (resp.ok){
                                                    location.reload();
                                                }else{
                                                    $("#errorEliminaProducto").modal("show");
                                                }
                                            }
                                        });
                                    });

                                });
                            </script>
                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>
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
    <?php include './templates/footer.php'; ?>
</body>

</html>