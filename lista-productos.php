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
                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th style="text-align:center;">Tipo</th>
                                <th style="text-align:center;">Nombre</th>
                                <th style="text-align:center;">Descripcion</th>
                                <th style="text-align:center;">Cantidad</th>
                                <th style="text-align:center;">Accion</th>
                            </tr>
                        </thead>
                        <tbody class="lista-productos">

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>

    <script>
        $(function() {
            var listaProductos = [];
            $.ajax({
                type: "post",
                dataType: "json",
                data: "accion=lista-productos",
                url: "procesaDatos.php",
                success: function(resp) {
                    if (resp.ok) {
                        listaProductos = resp.productos;
                    }
                    RecargarTabla(listaProductos);
                }
            });

            function RecargarTabla(tabla) {
                for (var i = 0; i < tabla.length; i++) {
                    $(".lista-productos").append(
                        '<tr id="tr-' + i + '">' +
                        '<td>' + tabla[i].TipoProducto + '</td>' +
                        '<td>' + tabla[i].Nombre + '</td>' +
                        '<td>' + tabla[i].Descripcion + '</td>' +
                        '<td>' + tabla[i].Cantidad + '</td>' +
                        '<td><button value="' + i + '" class="btn btn-success btn-repeat" id="btn-mostrarp-' + i + '">Mostrar</button></td>' +
                        '</tr>'
                    );
                    if (tabla[i].Asociados == true) {
                        $(".lista-productos").append(
                            '<tr id="tr-sub-' + i + '" style="display:none;">' +
                            '<td colspan="5">' +
                            '<table class="table">' +
                            '<thead >' +
                            '<tr>' +
                            '<th>Código</th>' +
                            '<th>Vencimiento</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody id="tbl-' + i + '">' +
                            //Aqui van los productos con código de barras
                            '</tbody>' +
                            '</table>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                    for (var j = 0; j < tabla[i].CodigoVencimiento.length; j++) {
                        $("#tbl-" + i).append(
                            '<tr>' +
                            '<td><span id="' + tabla[i].CodigoVencimiento[j].IdProducto + '-' + tabla[i].CodigoVencimiento[j].Codigo + '" class="codigo-barra" data-toggle="modal" data-target="#EditarProducto" data-backdrop="static" data-keyboard="false">' + tabla[i].CodigoVencimiento[j].Codigo + '</span></td>' +
                            '<td id="f-ven-' + tabla[i].CodigoVencimiento[j].IdProducto + '">' + tabla[i].CodigoVencimiento[j].FechaVencimiento + '</td>' +
                            '</tr>'
                        );
                    }
                }
            };

            $(document).on('click', '.btn-repeat', function() {
                var valor = $(this).val();
                if ($("#btn-mostrarp-" + valor + "").text() == "Mostrar") {
                    var opc = document.getElementById('tr-sub-' + valor).style;
                    opc.display = 'table-row';
                    $("#btn-mostrarp-" + valor + "").text("Ocultar");
                    $("#btn-mostrarp-" + valor + "").removeClass("btn-success");
                    $("#btn-mostrarp-" + valor + "").addClass("btn-danger");
                } else {
                    var opc = document.getElementById('tr-sub-' + valor).style;
                    opc.display = 'none';
                    $("#btn-mostrarp-" + valor + "").text("Mostrar");
                    $("#btn-mostrarp-" + valor + "").removeClass("btn-danger");
                    $("#btn-mostrarp-" + valor + "").addClass("btn-success");
                }
            });

            $(document).on('click', '.codigo-barra', function() {
                var codigo = $(this).attr("id").split("-")[1];
                var id = $(this).attr("id").split("-")[0];
                $("#recipient-name").val(codigo);
                $("#fecha-vencimiento").val($("#f-ven-" + id).text());
                $("#idprod").val(id);
            });

            var valActual;
            $("#recipient-name").focus(function() {
                valActual = $(this).val();
                $(this).val("");
            });

            $("#recipient-name").focusout(function() {
                if ($(this).val() == "") {
                    $(this).val(valActual);
                }
            });

        });
    </script>

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


    <!--MODAL ERROR-->
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

                    <input type="hidden" id="idprod">
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
                    <button type="button" class="btn btn-primary" id="btn-modificar"  >Guardar</button>
                </div>
            </div>
        </div>

        <!-- MODIFICAR PRODUCTO -->
        <script>
            $(function() {
                $("#btn-modificar").click(function() {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        data: {
                            "accion": "modificar-producto",
                            "codigo": $("#recipient-name").val(),
                            "vencimiento": $("#fecha-vencimiento").val(),
                            "idProducto": $("#idprod").val()
                        },
                        url: "procesaDatos.php",
                        success: function(resp) {
                            if (resp.ok) {
                                $("#EditarProducto").modal('hide');
                                $("#ModificaProducto").modal('show');

                            }else{
                                $("#EditarProducto").modal('hide');
                                $("#errorEditarProducto").modal('show');
                            }
                        }
                    });
                });

                $("#btn-recargar-pagina").click(function(){
                    location.reload();
                });

                $("#ModificaProducto").on('hidden.bs.modal',function(){
                    location.reload();
                });
            });
        </script>
    </div>
    <?php include './templates/footer.php'; ?>
</body>

</html>