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


        $sql1 = "SELECT * FROM producto_maestro WHERE Codigo = " . $producto["codigo"];
        $id = $mysql->query($sql1);
        if ($id->num_rows <= 0) {
            $sql2 = 'INSERT INTO producto_maestro (Codigo,Tipo,Nombre,Descripcion) '
                . ' VALUES("' . $producto["codigo"] . '",' . $producto["tipo"] . ',"' . $producto["nombre"] . '","' . $producto["descripcion"] . '")';
            $mysql->query($sql2);
            $id = $mysql->insert_id;
            if ($id <= 0) {
                $resp["ok"] = false;
                return $resp;
            }
        }

        $sql3 = "INSERT INTO producto (Codigo,FechaVencimiento)"
            . " VALUES('" . $producto["codigo"] . "','" . $producto["fechaVencimiento"] . "')";
        $mysql->query($sql3);
        $id = $mysql->insert_id;
        if ($id <= 0) {
            $resp["ok"] = false;
            return $resp;
        }


        $sqlBitacora = 'INSERT INTO historico_producto (IdProducto,TipoMOV,CantidadMOV,UsuarioModifica,FechaModifica) values '
            . '(' . $id . ',1,1,' . $IdUsuario . ',DATE_SUB(now(),INTERVAL 6 HOUR))';
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
        $sql = 'UPDATE producto SET Codigo = "' . $producto["codigo"] . '",FechaVencimiento = "' . $producto["vencimiento"] . '" WHERE IdProducto = ' . $producto["idProducto"];
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
        } else {
            $resp["ok"] = true;
        }

        $sql = "DELETE from historico_producto WHERE IdProducto = " . $datos["IdProducto"];
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        } else {
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

    function ConsultarProductoXCodigo($producto)
    {
        require './conexion.php';
        $resp = array();
        $query = ""; //Inicializar variable
        $query = "SELECT * FROM producto_maestro WHERE Codigo = " . $producto["codigo"] . "";
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

    /* function ListaProductos()
    {
        require './conexion.php';
        $resp = array();
        $query = "select tipo_producto.TipoProducto,producto.Nombre, producto.Descripcion, count(*) as 'Cantidad' from producto, tipo_producto where producto.Tipo = tipo_producto.IdTipo and producto.Cantidad > 0 group by tipo_producto.TipoProducto,producto.Nombre,producto.Descripcion order by tipo_producto.TipoProducto, producto.Nombre,producto.Descripcion;";
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
    } */

    function ListaProductos()
    {
        require './conexion.php';
        $resp = array();
        $query = "select tipo_producto.TipoProducto,producto.Nombre, producto.Descripcion, count(*) as 'Cantidad' from producto, tipo_producto where producto.Tipo = tipo_producto.IdTipo and producto.Cantidad > 0 group by tipo_producto.TipoProducto,producto.Nombre,producto.Descripcion order by tipo_producto.TipoProducto, producto.Nombre,producto.Descripcion;";
        $resultado = $mysql->query($query);
        if ($resultado->num_rows > 0) {
            $resp["ok"] = true;
            $productos = array();
            while ($producto = $resultado->fetch_assoc()) {
                array_push($productos, $producto);
            }
            for ($i = 0; $i < count($productos); $i++) {

                #Ignora comilla simple para poder realizar query
                $tipo = str_replace("'", "\'", $productos[$i]["TipoProducto"]);
                $nombre = str_replace("'", "\'", $productos[$i]["Nombre"]);
                $descripcion = str_replace("'", "\'", $productos[$i]["Descripcion"]);
                #-----------------------------------------------

                $query = "SELECT producto.IdProducto,producto.Codigo, producto.FechaVencimiento "
                    . "FROM producto, tipo_producto WHERE producto.Tipo = tipo_producto.IdTipo AND tipo_producto.TipoProducto = '" . $tipo . "' AND "
                    . "producto.Nombre = '" . $nombre . "' AND producto.Descripcion = '" . $descripcion . "'  ORDER BY tipo_producto.TipoProducto;";
                $resultado = $mysql->query($query);
                if (!$resultado) {
                    trigger_error('Invalid query: ' . $mysql->error);
                }
                if ($resultado->num_rows > 0) {
                    $productos2 = array();
                    while ($producto2 = $resultado->fetch_assoc()) {
                        array_push($productos2, $producto2);
                    }
                    $productos[$i]["Asociados"] = true;
                    $productos[$i]["CodigoVencimiento"] = $productos2;
                } else {
                    $productos[$i]["Asociados"] = false;
                }
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
        $sql = 'DELETE FROM producto  WHERE IdProducto = ' . $producto["IdProducto"] . '';
        $mysql->query($sql);
        if ($mysql->affected_rows <= 0) {
            $resp["ok"] = false;
            return $resp;
        }
        $sqlBitacora = 'INSERT INTO historico_producto (IdProducto,TipoMOV,CantidadMOV,UsuarioModifica,FechaModifica) values '
            . '(' . $producto["IdProducto"] . ',0,1,' . $IdUsuario . ',DATE_SUB(now(),INTERVAL 6 HOUR))';
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
        /* $query = "SELECT producto.Nombre,producto.Descripcion,TipoMOV,CantidadMOV,concat(usuario.Nombre,' ',usuario.Apellidos) as Responsable,historico_producto.FechaModifica FROM historico_producto,producto,usuario"
            . " where "
            . " historico_producto.IdProducto = producto.IdProducto AND "
            . " historico_producto.UsuarioModifica = usuario.IdUsuario"
            . " order by historico_producto.FechaModifica desc"; */

            $query = "";

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
