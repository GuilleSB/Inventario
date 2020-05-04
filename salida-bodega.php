<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Descontar productos</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>
    <!--BARRA DE NAVEGACION-->
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="div-salida">
                    <h4 class="salida-bodega">
                        Salida de bodega
                    </h4>
                </div>
                <div class="form-group row slider0">
                    <label for="tipo" class="col-sm-2 col-form-label">Tipo de producto</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipo">
                            <option value="">Seleccione una opción...</option>
                            <?php
                            include './class/TipoProducto.php';
                            $TipoProducto = new TipoProducto();
                            $tipoProducto = $TipoProducto->ListaTipoProducto();
                            $prod = $tipoProducto["productos"];
                            for ($i = 0; $i < count($prod); $i++) {
                                echo '<option value="' . $prod[$i]["IdTipo"] . '">' . $prod[$i]["TipoProducto"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <script>
                    var productos = [];
                    $(function() {
                        $(".slider1").hide();
                        $("#tipo").change(function() {
                            $(".slider1").hide(); //Oculta al cambiar de tipo de producto
                            if ($(this).val() == "") { //Si no selecciona producto esconde div
                                $(".slider1").hide();
                                return;
                            }

                            $.ajax({ //Llamada asíncrona
                                type: "POST",
                                dataType: "json",
                                url: "procesaDatos.php",
                                data: {
                                    "tipo": $(this).val(),
                                    "accion": "consultar-producto"
                                },
                                success: function(resp) {
                                    if (resp.ok) {
                                        productos = [];
                                        $("#producto").empty();
                                        $("#producto").append('<option value="" selected>Seleccione una opcion...</option>');
                                        for (var i = 0; i < resp.productos.length; i++) {
                                            productos.push(resp.productos[i]);
                                            $("#producto").append(
                                                '<option value="' + resp.productos[i].IdProducto + '">' + resp.productos[i].Nombre + ' - ' + resp.productos[i].Descripcion + ' - ' + resp.productos[i].FechaVencimiento + '</option>'
                                            );
                                        }
                                        $("#cantidadProducto").removeAttr("readonly");
                                        $(".slider1").show();
                                    } else {
                                        productos = [];
                                        $("#producto").empty();
                                        $("#producto").append('<option value="" selected>No hay productos registrados</option>');
                                        $("#cantidadProducto").val("");
                                        $("#cantidadProducto").attr("readonly", "readonly");
                                        $(".slider1").show();
                                    }
                                },
                                error: function(err) {}
                            });
                        });
                    });
                </script>

                <div class="form-group row slider1">
                    <label for="tipo" class="col-sm-2 col-form-label">Producto</label>
                    <div class="col-9 col-sm-8">
                        <select class="form-control" id="producto">

                        </select>
                    </div>
                    <div class="col-3 col-sm-2">
                        <input type="number" min="1" class="form-control" id="cantidadProducto">
                    </div>
                </div>
                <input type="hidden" id="bandera" value="0" />
                <div class="row justify-content-end">
                    <div class="col-auto panel-boton">
                        <input type="button" class="btn btn-primary" value="Agregar a lista preliminar" id="btnIngresoLista" />
                    </div>
                </div>
                <script>
                    $(function() {

                        var productosABodega = [];

                        //LLENAR TABLA
                        $("#btnIngresoLista").click(function() {
                            //Validaciones
                            if ($("#tipo").val() == "") {
                                alert("Debe seleccionar un tipo de producto");
                                return;
                            }
                            if ($("#producto").val() == "") {
                                alert("Debe seleccionar un producto");
                                return;
                            }
                            if ($("#cantidadProducto").val() == "") {
                                alert("Debe digitar una cantidad a ingresar");
                                return;
                            }
                            if ($("#cantidadProducto").val() <= 0) {
                                alert("La cantidad debe ser igual o mayor a 1");
                                return;
                            }
                            //------------

                            for (var i = 0; i < productos.length; i++) {
                                if (productos[i].IdProducto == $("#producto").val()) {
                                    var bandera = 0;
                                    for (var j = 0; j < productosABodega.length; j++) {
                                        if (productos[i].IdProducto == productosABodega[j].productos.IdProducto) {

                                            if ((productos[i].Cantidad - (parseInt(productosABodega[j].cantidad) + parseInt($("#cantidadProducto").val()))) < 0) {
                                                bandera = 2;
                                                break;
                                            } else {
                                                productosABodega[j].cantidad = parseInt(productosABodega[j].cantidad) + parseInt($("#cantidadProducto").val());
                                                bandera = 1;
                                                break;
                                            }
                                        }
                                    }
                                    if (bandera == 1) {
                                        continue;
                                    }
                                    if (bandera == 2) {
                                        alert("No existe tal cantidad de artículos");
                                        break;
                                    }

                                    if ((productos[i].Cantidad - parseInt($("#cantidadProducto").val())) < 0) {
                                        alert("No existe tal cantidad de artículos");
                                        break;
                                    } else {
                                        productosABodega.push({
                                            "productos": productos[i],
                                            "cantidad": $("#cantidadProducto").val()
                                        });
                                    }
                                }
                            }
                            RecargarTabla();
                        });

                        var limpiar = function() {
                            $("#tipo").val("");
                            $("#producto").val("");
                            $("#cantidadProducto").val("");
                            $(".slider1").hide();
                        };

                        $(document).on("click", "#editarProducto", function() {
                            var id = $(this).val().split("-")[1];
                            var valorAnterior = $("#" + id).text();
                            if ($(this).text() == "Editar") {
                                var id = $(this).val().split("-")[1];
                                var valorAnterior = $("#" + id).text();
                                //MODIFICAR BOTON EDITAR
                                $(this).text("Aplicar");
                                $(this).removeClass("btn-secondary");
                                $(this).addClass("btn-warning");
                                $("#" + id).empty();
                                $("#" + id).append(
                                    '<input type="number" class="form-control" style="width:70px" id="edit' + id + '" value="' + valorAnterior + '" min="1" />'
                                );
                            } else {
                                var cantidad = $("#edit" + id).val();
                                productosABodega.map(function(dato) {
                                    if (dato.productos.IdProducto == id) {
                                        if ((parseInt(dato.cantidad - parseInt($("#edit" + id).val()))) < 0) {
                                            alert("No existe tal cantidad de artículos");
                                        } else {
                                            dato.cantidad = $("#edit" + id).val();
                                        }
                                    }
                                    RecargarTabla();
                                });

                            }
                        });


                        $(document).on("click", "#eliminarProducto", function() {
                            var id = $(this).val().split("-")[1];
                            for (var i = 0; i < productosABodega.length; i++) {
                                if (productosABodega[i].productos.IdProducto == id) {
                                    productosABodega.splice(i, 1);
                                }
                            }
                            RecargarTabla();
                        });


                        var RecargarTabla = function() { //Recargar tabla
                            $("#ingreso-bodega").empty();
                            for (var i = 0; i < productosABodega.length; i++) {
                                $("#ingreso-bodega").append(
                                    '<tr class="slider2">' +
                                    '<td align="center">[' + productosABodega[i].productos.IdProducto + '] - ' + productosABodega[i].productos.Nombre + '</td>' +
                                    '<td align="center" id="' + productosABodega[i].productos.IdProducto + '">' + productosABodega[i].cantidad + '</td>' +
                                    '<td align="center">' +
                                    '<button type="button" value="' + productosABodega[i].productos.Tipo + '-' + productosABodega[i].productos.IdProducto + '" id="editarProducto" class="btn btn-secondary btn-sm" style="margin-right:3px;">Editar</button>' +
                                    '<button type="button" value="' + productosABodega[i].productos.Tipo + '-' + productosABodega[i].productos.IdProducto + '" class="btn btn-danger btn-sm" id="eliminarProducto">Eliminar</button>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            }
                            $(".slider2").hide();
                            $(".slider2").show();
                            limpiar();
                        }

                        setInterval(function() {
                            if (parseInt(productosABodega.length) > 0) {
                                $(".slider3").show();
                            } else {
                                $(".slider3").hide();
                            }
                        }, 10);

                        //GUARDAR EN BASE DE DATOS INGRESO A BODEGA
                        $("#btnSalidaBodega").click(function() {
                            $.ajax({
                                type: "post",
                                dataType: "json",
                                data: {
                                    "datos": productosABodega,
                                    "accion": "salida-bodega"
                                },
                                url: "procesaDatos.php",
                                success: function(resp) {
                                    if (resp.ok) {
                                        $("#confirmaSalidaBodega").modal('show');
                                        productosABodega = [];
                                        RecargarTabla;
                                    } else {
                                        $("#errorSalidaBodega").modal('show');
                                    }
                                },
                                error: function(err) {

                                }
                            });
                        });
                    });
                </script>
                <hr>
                <!--TABLA PARA VISUALIZAR PRODUCTOS A AGREGAR-->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:center">Producto</th>
                            <th scope="col" style="text-align:center">Cantidad</th>
                            <th scope="col" style="text-align:center">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="ingreso-bodega">

                    </tbody>
                </table>
                <div class="row justify-content-center">
                    <div class="col-auto slider3">
                        <input type="button" class="btn btn-success" value="Descontar productos" id="btnSalidaBodega" />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="confirmaSalidaBodega" tabindex="-1" role="dialog" aria-labelledby="confirmaSalidaBodegaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="confirmaSalidaBodegaTitle" style="color:white;">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Se descontaron los productos en bodega correctamente!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="recargarPagina" data-dismiss="modal">OK</button>
                    <script>
                        $(function() {
                            $("#recargarPagina").click(function() {
                                location.reload();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL ERROR-->
    <div class="modal fade" id="errorSalidaBodega" tabindex="-1" role="dialog" aria-labelledby="errorSalidaBodegaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorSalidaBodegaTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al descontar productos de bodega
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