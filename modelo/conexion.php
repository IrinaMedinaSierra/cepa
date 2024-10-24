<?php
/*
 * Este archivo contiene todo lo necesario para que esta aplicación se conecte
 * con la BBDD personas y pueda realizarse consultas, inserciones , elmilinación
 * actualizaciones
 * */
//1.Definir los parámetros de conexion
$servidor = "localhost";//nombre del servidor
$usuario = "root"; // nombre el usuario
$password = ""; //contraseña del usuario
$puerto = "3306";//puerto de conexión a la base de datos
$bbdd="cepa";
//creamos la conexión

function conectar()
{
    global $servidor, $usuario, $password, $puerto,$bbdd;
    $conexion = mysqli_connect($servidor.":".$puerto, $usuario, $password);
    //verificar si se conecta la bbdd
    if(mysqli_error($conexion)){
      //  echo "Error al conectar con la base de datos";
    }else{
        //echo "Conexión realizada correctamente"; //temporalmente
    }
    if (!mysqli_select_db($conexion, $bbdd)) {
     //   echo "<br>Error al conectar con la base de datos";
        exit();
    }else{
      //  echo "<br>Conexión con la BBDD realizada correctamente";
    }
    return $conexion;
}
//$conexion = conectar();

