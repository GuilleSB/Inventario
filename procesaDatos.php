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

    case "consultar-xcodigo":
        $resp = $Producto->ConsultarProductoXCodigo($_POST);
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
    case "consultar-bodega":
        break;
}



/* function convert_from_latin1_to_utf8_recursively($dat)
{
   if (is_string($dat)) {
      return utf8_encode($dat);
   } elseif (is_array($dat)) {
      $ret = [];
      foreach ($dat as $i => $d) $ret[ $i ] =self::convert_from_latin1_to_utf8_recursively($d);

      return $ret;
   } elseif (is_object($dat)) {
      foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

      return $dat;
   } else {
      return $dat;
   }
} */
// Sample use
// Just pass your array or string and the UTF8 encode will be fixed
$data = mb_convert_encoding($resp, 'UTF-8', 'UTF-8');

$json = json_encode($data);


if ($json) {
    echo $json;
} else {
    echo json_last_error_msg();
}
