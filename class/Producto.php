<?php

class Producto
{
    private $IdProducto;
    private $Tipo;
    private $Nombre;
    private $Descripcion;
    private $Cantidad;
    private $Medida;


    function __construct()
    {
        $this->IdProducto = 0;
        $this->Tipo = 0;
        $this->Nombre = "";
        $this->Descripcion = "";
        $this->Cantidad = 0;
        $this->Medida = 0;
    }


    function IngresarProducto($producto)
    {
        //OBTENER USUARIO
        session_start();
        $IdUsuario  = $_SESSION["usuario"]["IdUsuario"];

        require './conexion.php';
        $resp = array();
        $tipo = explode("-", $producto["tipo"]);
        $sql = 'INSERT INTO producto (Tipo,Nombre,Descripcion,Cantidad,FechaVencimiento) VALUES(' . $tipo[0] . ',"' . $producto["nombre"] . '","' . $producto["descripcion"] . '",' . $producto["cantidad"] . ',"' . $producto["fechaVencimiento"] . '")';
        $mysql->query($sql);
        $id = $mysql->insert_id;
        if ($id <= 0) {
            $resp["ok"] = false;
            return $resp;
        }

        $sqlBitacora = 'INSERT INTO historico_producto (IdProducto,TipoMOV,CantidadMOV,UsuarioModifica,FechaModifica) values '
            . '(' . $id . ',1,' . $producto["cantidad"] . ',' . $IdUsuario . ',DATE_SUB(now(),INTERVAL 6 HOUR))';
        $mysql->query($sqlBitacora);
        if ($mysql->insert_id > 0) {
            $resp["ok"] = true;
        } else {
            $resp["ok"] = false;
        }

        $mysql->close();
        return $resp;
    }

    function ModificarProducto($producto)
    {
        require './conexion.php';
        $resp = array();
        $sql = 'UPDATE producto SET Nombre = "' . $producto["nombre"] . '",Descripcion = "' . $producto["descripcion"] . '" WHERE IdProducto = ' . $producto["idProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows > 0) {
            $resp["ok"] = true;
            return $resp;
        }
        $resp["ok"] = false;
        return $resp;
    }

    function EliminarProducto($datos)
    {
        require './conexion.php';
        $resp = array();
        $sql = 'DELETE from producto WHERE IdProducto = ' . $datos["IdProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        }else{
            $resp["ok"] = true;
        }

        $sql = "DELETE from historico_producto WHERE IdProducto = " . $datos["IdProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        }else{
            $resp["ok"] = true;
        }        
        return $resp;
    }

    function ConsultarProductoXTipo($producto)
    {
        require './conexion.php';
        $resp = array();
        $query = ""; //Inicializar variable
        $query = "SELECT * FROM producto WHERE Tipo = " . explode("-", $producto["tipo"])[0] . " AND Cantidad > 0";
        $resultado = $mysql->query($query);
        if ($resultado->num_rows > 0) {
            $resp["ok"] = true;
            $productos = array();
            while ($producto = $resultado->fetch_assoc()) {
                array_push($productos, $producto);
            }
            $resp["productos"] = $productos;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }

    function ListaProductos()
    {
        require './conexion.php';
        $resp = array();
        $query = "select IdProducto,tipo_producto.TipoProducto,producto.Nombre, producto.Descripcion, Cantidad, producto.FechaVencimiento from producto, tipo_producto where producto.Tipo = tipo_producto.IdTipo and producto.Cantidad > 0";
        $resultado = $mysql->query($query);
        if ($resultado->num_rows > 0) {
            $resp["ok"] = true;
            $productos = array();
            while ($producto = $resultado->fetch_assoc()) {
                array_push($productos, $producto);
            }
            $resp["productos"] = $productos;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }

    function IngresoBodega($producto, $IdUsuario)
    {
        require './conexion.php';

        $resp = array();
        $sql = 'UPDATE producto SET Cantidad = Cantidad + ' . $producto["cantidad"] .
            ' WHERE IdProducto = ' . $producto["productos"]["IdProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        }

        $sqlBitacora = 'INSERT INTO historico_producto (IdProducto,TipoMOV,CantidadMOV,UsuarioModifica,FechaModifica) values '
            . '(' . $producto["productos"]["IdProducto"] . ',1,' . $producto["cantidad"] . ',' . $IdUsuario . ',DATE_SUB(now(),INTERVAL 6 HOUR))';
        $mysql->query($sqlBitacora);
        if ($mysql->insert_id > 0) {
            $resp["ok"] = true;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }

    function SalidaBodega($producto, $IdUsuario)
    {
        require './conexion.php';

        $resp = array();
        $sql = 'UPDATE producto SET Cantidad = Cantidad - ' . $producto["cantidad"] .
            ' WHERE IdProducto = ' . $producto["productos"]["IdProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        }
        $sqlBitacora = 'INSERT INTO historico_producto (IdProducto,TipoMOV,CantidadMOV,UsuarioModifica,FechaModifica) values '
            . '(' . $producto["productos"]["IdProducto"] . ',0,' . $producto["cantidad"] . ',' . $IdUsuario . ',DATE_SUB(now(),INTERVAL 6 HOUR))';
        $mysql->query($sqlBitacora);
        if ($mysql->insert_id > 0) {
            $resp["ok"] = true;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }

    function Bitacora()
    {
        require './conexion.php';
        $resp = array();
        $query = "SELECT producto.Nombre,producto.Descripcion,TipoMOV,CantidadMOV,concat(usuario.Nombre,' ',usuario.Apellidos) as Responsable,historico_producto.FechaModifica FROM historico_producto,producto,usuario"
            . " where "
            . " historico_producto.IdProducto = producto.IdProducto AND "
            . " historico_producto.UsuarioModifica = usuario.IdUsuario"
            . " order by historico_producto.FechaModifica desc";

        $resultado = $mysql->query($query);
        if ($resultado->num_rows > 0) {
            $resp["ok"] = true;
            $productos = array();
            while ($producto = $resultado->fetch_assoc()) {
                array_push($productos, $producto);
            }
            $resp["productos"] = $productos;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }
}
