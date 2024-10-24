<?php
session_start();
$errores=array();
if ($_REQUEST["origen"]==="formulario1") {
        validarCpostal($_REQUEST["cp"]);
        validarDni($_REQUEST["dni"]);
        validarEdad($_REQUEST["fNacimiento"]);
        validarTexto($_REQUEST["nombre"],"nombre");
        validarTexto($_REQUEST["pApellido"],"apellido");
        validarTelefono($_REQUEST["telefono"]);
        validarVacio($_REQUEST["provincia"],"La provincia");
        validarVacio($_REQUEST["fechaUE"],"La Fecha ultimo estudio");
        validarVacio($_REQUEST["direccion"],"La Direccion");
        validarVacio($_REQUEST["uEstudio"],"El ultimo estudio");

      if (count($errores)>0) {
          for($i=0;$i<count($errores);$i++){
              $todosLosErrores.=$errores[$i];
          }
          header("Location:../vista/formulario1.php?errores=$todosLosErrores");
    }else{
    $_SESSION["cp"] = $_REQUEST["cp"];
    //...
    header("Location:../vista/formulario2.php");
}
}
if ($_REQUEST["origen"]==="formulario2") {
    validarTexto($_REQUEST["nombreFamiliar"],"Persona Contacto");
    validarTelefono($_REQUEST["telefonoFamiliar"]);
    validarVacio($_REQUEST["relacion"],"La relacion");
    if (count($errores)>0) {
        for ($i = 0; $i < count($errores); $i++) {
            $todosLosErrores .= $errores[$i];
        }
        header("Location:../vista/formulario2.php?errores=$todosLosErrores");
    }else {
        // leer los datos...
        header("Location:../vista/confirmacion.php");
    }


}
function validarTexto($texto,$variable){
    global $errores;
    if (empty($texto) || !is_string($texto) || preg_match("/[0-9]/", $texto)) {// no es un string y tiene numeros
        $errores[]="<p>El $variable no puede ser vacio y ni contener numeros</p>";
        return false;
    }else{
        return true;
    }
}
function validarVacio($valor,$variable){
    global $errores;
    if  (empty($valor)){
        $errores[]="<p>$variable no puede ser vacio</p>";
        return false;
    }else{
        return true;
    }
}

function validarTelefono($telefono)
{
    return true; //temporalmente
}


function validarEdad($edad)
{
    return true; //temporalmente
}
function validarDni($dni){
     return true; //temporalmente
}
function validarCpostal($cp)
{
    return true; //temporalmente
}
