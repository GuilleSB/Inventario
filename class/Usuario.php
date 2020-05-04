<?php

class Usuario{
    private $IdUsuario;
    private $Identificacion;
    private $Nombre;
    private $Apellidos;
    private $Correo;
    private $Telefono;
    private $Clave;

    function __construct()
    {
        $this->IdUsuario = 0;
        $this->Identificacion = 0;
        $this->Nombre = "";
        $this->Apellidos = "";
        $this->Correo = "";
        $this->Telefono = "";
        $this->Clave ="";
    }

    function Login($usuario){
        require './conexion.php';
        $resp = array();
        $query = "SELECT * FROM usuario WHERE ";
        $query .= "Correo='" . $usuario["correo"] . "' AND Clave='" . md5($usuario["clave"]) . "'";

        $resultado = $mysql->query($query);

        if ($resultado->num_rows > 0) {
            $resp["ok"] = true;
            $usuario = array();
            session_start();
            $usuario = $resultado->fetch_assoc();
            $_SESSION["usuario"] = array(
                "IdUsuario" => $usuario["IdUsuario"],
                "Identificacion" => $usuario["Identificacion"],
                "Nombre" => $usuario["Nombre"],
                "Apellidos" => $usuario["Apellidos"],
                "Correo" => $usuario["Correo"],
                "Telefono" => $usuario["Telefono"]
            );
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }


    function Registro($usuario){
        require './conexion.php';
        $resp = array();

        //Validar correo permitido
        $sqlValida = 'SELECT * FROM correos_permitidos WHERE Correo = "'. md5($usuario["correo"]). '" ';
        $temp = $mysql->query($sqlValida);
        if ($temp->num_rows <= 0){
            return $resp["ok"] = false;
        }
        //------------------------
        $sql = "INSERT INTO usuario (Identificacion,Nombre,Apellidos,Correo,Telefono,Clave) VALUES(";
        $sql .= "'". $usuario["identificacion"]. "',";
        $sql .= "'". $usuario["nombre"]. "',";
        $sql .= "'". $usuario["apellidos"]. "',";
        $sql .= "'". $usuario["correo"]. "',";
        $sql .= "'". $usuario["telefono"]. "',";
        $sql .= "'". md5($usuario["clave"]). "')";
        $mysql->query($sql);
        if ($mysql->insert_id > 0) {
            $resp["ok"] = true;
        } else {
            $resp["ok"] = false;
        }
        return $resp;
    }

}