<?php

include './class/Producto.php';
include './class/TipoProducto.php';
include './class/Usuario.php';

$Producto = new Producto();
$TipoProducto = new TipoProducto();
$Usuario = new Usuario();

$accion = $_POST["accion"];
$resp = array();

switch ($accion) {
        //Usuarios
    case "login":
        $resp = $Usuario->Login($_POST);
        break;

    case "registro":
        $resp = $Usuario->Registro($_POST);
        break;

    case "logout":
        session_start();
        session_destroy();
        header("Location:index.php");
        break;


        //Productos
    case "ingresar-producto":
        $resp = $Producto->IngresarProducto($_POST);
        break;

    case "modificar-producto":
        $resp = $Producto->ModificarProducto($_POST);
        break;

    case "eliminar-producto":
        $resp = $Producto->EliminarProducto($_POST);
        break;

    case "consultar-producto":
        $resp = $Producto->ConsultarProductoXTipo($_POST);
        break;

    case "lista-productos":
        $resp = $Producto->ListaProductos();
        break;

    case "ingresar-tipoProducto":
        $resp = $TipoProducto->IngresarTipoProducto($_POST);
        break;

    case "lista-tipoProducto":
        $resp = $TipoProducto->ListaTipoProducto();
        break;

    case "eliminar-tipoProducto":
        $resp = $TipoProducto->EliminarTipoProducto($_POST);
        break;

    case "ingreso-bodega":
        //OBTENER USUARIO
        session_start();
        $IdUsuario  = $_SESSION["usuario"]["IdUsuario"];
        for ($i = 0; $i < count($_POST["datos"]); $i++) {
            $resp = $Producto->IngresoBodega($_POST["datos"][$i], $IdUsuario);
        }
        break;

    case "salida-bodega":
        //OBTENER USUARIO
        session_start();
        $IdUsuario  = $_SESSION["usuario"]["IdUsuario"];
        for ($i = 0; $i < count($_POST["datos"]); $i++) {
            $resp = $Producto->SalidaBodega($_POST["datos"][$i], $IdUsuario);
        }
        break;
        break;

    case "consultar-bodega":
        break;
}

echo json_encode($resp);
