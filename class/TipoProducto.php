<?php

class TipoProducto{
    private $IdTipo;
    private $TipoProducto;
    private $UnidadMedida;

    function __construct()
    {
        $this->IdTipo = 0;
        $this->TipoProducto = "";
        $this->UnidadMedida = "";
    }


    function IngresarTipoProducto($tipoProducto){
        require 'conexion.php';
        
        $resp = array();
        $sql = 'INSERT INTO tipo_producto (TipoProducto) VALUES("'. $tipoProducto["tipoProducto"] .'")';
       
        $mysql->query($sql);
        if ($mysql->insert_id > 0) {
            $resp["ok"] = true;
            return $resp;
        }
        $resp["ok"]= false;
        return $resp;
    }

    function ModificarTipoProducto($tipoProducto){
        require './conexion.php';
        $resp = array();
        $sql = 'UPDATE tipo_producto SET TipoProducto = "' . $tipoProducto["tipoProducto"] . '"
         WHERE IdTipo = ' . $tipoProducto["idTipo"];
        $mysql->query($sql);
        if ($mysql->affected_rows > 0) {
            $resp["ok"] = true;
            return $resp;
        }
        $resp["ok"]= false;
        return $resp;
    }

    function EliminarTipoProducto($tipoProducto){
        require './conexion.php';
        $resp = array();
        $sql = 'DELETE FROM tipo_producto WHERE IdTipo = ' . $tipoProducto["idTipo"];
        $mysql->query($sql);
        if ($mysql->affected_rows > 0) {
            $resp["ok"] = true;
            return $resp;
        }
        $resp["ok"]= false;
        return $resp;
    }


    function ListaTipoProducto(){
        require './conexion.php';
        $resp = array();
        $query = "SELECT * FROM tipo_producto";
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





