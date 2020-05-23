<?php include './validacion.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ingreso en bodega</title>
    <?php include './referencias.php' ?>
</head>

<body>
    <?php include './templates/navbar.php'; ?>
    <!--BARRA DE NAVEGACION-->
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="subtitulo">
                    Ingreso a bodega
                </h4>
                <div class="form-group row">
                    <label for="codigo" class="col-sm-2 col-form-label">Código producto</label>
                    <div class="col-sm-10">
                        <form id="buscaProductos">
                            <input class="form-control" type="text" id="codigo" />
                        </form>
                        <script>
                            $(function() {
                                $("#codigo").focus();
                                $("#buscaProductos").submit(function(e) {
                                    e.preventDefault();

                                    $.ajax({
                                        type: "post",
                                        dataType: "json",
                                        data: {
                                            "accion": "consultar-xcodigo",
                                            "codigo": $("#codigo").val()
                                        },
                                        url: "procesaDatos.php",
                                        success: function(resp) {
                                            if (resp.ok) {
                                                $("#nombre").val(resp.productos[0].Nombre);
                                                $("#descripcion").val(resp.productos[0].Descripcion);
                                                $("#tipo option[value=" + resp.productos[0].Tipo + "]").attr("selected", true);

                                                $("#tipo").attr("disabled", "disabled");
                                                $("#nombre").attr("disabled", "disabled");
                                                $("#descripcion").attr("disabled", "disabed");
                                                $("#btnIngresaProducto").text("Ingresar producto");

                                            } else {
                                                $("#CreaNuevoProducto").modal("show");

                                                $("#tipo").removeAttr("disabled");
                                                $("#nombre").removeAttr("disabled");
                                                $("#descripcion").removeAttr("disabled");
                                                $("#btnIngresaProducto").text("Crear e ingresar");
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tipo" class="col-sm-2 col-form-label">Tipo de producto</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipo" disabled>
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

                <div class="form-group row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="nombre" disabled />
                    </div>

                </div>

                <div class="form-group row">
                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="descripcion" disabled />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fechaVencimiento" class="col-sm-2 col-form-label">Vencimiento</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="date" id="fechaVencimiento" />
                    </div>
                </div>

                <button class="btn btn-primary" id="btnIngresaProducto">Ingresar producto</button>
                <script>
                    $(function() {
                        $("#btnIngresaProducto").click(function() {
                            $.ajax({
                                type: "post",
                                dataType: "json",
                                data: {
                                    "accion": "ingresar-producto",
                                    "codigo": $("#codigo").val(),
                                    "tipo": $("#tipo").val(),
                                    "nombre": $("#nombre").val(),
                                    "descripcion": $("#descripcion").val(),
                                    "fechaVencimiento": $("#fechaVencimiento").val()
                                },
                                url: "procesaDatos.php",
                                success: function(resp) {
                                    if (resp.ok) {
                                        $("#confirmaIngresoBodega").modal("show");
                                    } else {
                                        $("#errorIngresoBodega").modal("show");
                                    }
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <!--MODAL CREACION EXITOSA-->
    <div class="modal fade" id="confirmaIngresoBodega" tabindex="-1" role="dialog" aria-labelledby="confirmaIngresoBodegaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="confirmaIngresoBodegaTitle" style="color:white;">Éxito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¡Se creó ingresó a bodega correctamente!
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
    <div class="modal fade" id="errorIngresoBodega" tabindex="-1" role="dialog" aria-labelledby="errorIngresoBodegaTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="errorIngresoBodegaTitle" style="color:white;">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Error al ingresar producto a bodega
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL DEBE CREAR UN NUEVO PRODUCTO-->
    <div class="modal fade" id="CreaNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="CreaNuevoProductoTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="CreaNuevoProductoTitle" style="color:white;">Mensaje del sistema</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    El producto no existe aún, debe crearlo primero
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="recargarPagina" data-dismiss="modal">OK</button>
                    <script>
                        $(function() {
                            $("#recargarPagina").click(function() {
                                $("#nombre").focus();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php include './templates/footer.php'; ?>
    <!--BARRA INFERIOR-->
</body>

</html>