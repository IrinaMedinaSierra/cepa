<?php
    if (!empty($_REQUEST["id"]) ){
        require_once "../modelo/conexion.php";
        $link=conectar ();
       $id=$_REQUEST["id"];
       $consulta1="select * from alumno where idAlumno=$id";
       $resultado=mysqli_query ($link,$consulta1);
       $alumno[]=mysqli_fetch_assoc($resultado);
        foreach ($alumno as $item){
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CEPA-Modificar</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/formulario1.js"></script>
</head>
<body>
<h1>Formulario de Alta de nuevo Alumno</h1>
<h2 class="centrado">1️⃣⇢ Datos personales del Alumno</h2>
<form action="../controlador/controlador.php" method="post">
    <input type="hidden" name="origen" value="modificarA">
    <div class="formulario dosColumnas">
        <!--        IZQUIERDA-->
        <div>
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?=$item['nombre']?>">
            </p>
            <p>
                <label for="pApellido">Primer Apellido:</label>
                <input type="text" name="pApellido" id="pApellido" value="<?=$item['primerApellido']?>">
            </p>
            <p>
                <label for="sApellido">Segundo Apellido:</label>
                <input type="text" name="sApellido" id="sApellido" value="<?=$item['segundoApellido']?>">
            </p>
            <p>
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni" value="<?=$item['dni']?>">
            </p>
            <p>
                <label for="uEstudio">Último Estudio Cursado:</label>
                <select name="uEstudio" id="uEstudio">
                    <option></option>
                    <?php
                    include_once("../modelo/conexion.php"); //invocamos el archivo que carga la BBDD
                    $link = conectar();//ejecutas la funcion conectar()
                    $consulta = "SELECT * FROM nivelestudios"; //se guarda en una variable la consulta
                    $resultado = mysqli_query($link, $consulta);//se ejecuta la consulta
                    while ($fila = mysqli_fetch_assoc($resultado)) { //recorrer el array y guardar en $fila que es cada
                        //registro asociado a cada campo-> ej: $fila["idEstudios"]   / $fila["nombreNivel"]
                        if ($fila["idEstudios"]==$item["idEstudios"]){
	                        echo "<option value='$fila[idEstudios]' selected> $fila[nombreNivel]</option>";
	                        
                        }else{
                        echo "<option value='$fila[idEstudios]'> $fila[nombreNivel]</option>";
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="fechaUE">Fecha del último Estudio</label>
                <input type="date" name="fechaUE" id="fechaUE" value="<?=$item['fechaUltimoEst']?>">
            </p>
        </div>
        <!--        DERECHA-->
        <div>
            <p>
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?=$item['telefono']?>">
            </p>
            <p>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" value="<?=$item['direccion']?>">
            </p>
            <p>
                <label for="cp">Código Postal:</label>
                <input type="text" name="cp" id="cp" maxlength="5" value="<?=$item['cp']?>">
            </p>
            <p>
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad" value="<?=$item['ciudad']?>">
            </p>
            <p>
                <label for="provincia">Provincia</label>
                <select name="provincia" id="provincia"><?php
                    $link = conectar();//ejecutas la funcion conectar()
                    
                    $consulta = "SELECT * FROM provincia"; //se guarda en una variable la consulta
                    $resultado = mysqli_query($link, $consulta);//se ejecuta la consulta
                    while ($fila = mysqli_fetch_assoc($resultado)) { //recorrer el array y guardar en $fila que es cada
                        //registro asociado a cada campo-> ej: $fila["idEstudios"]   / $fila["nombreNivel"]
                        if ($fila['idProvincia']==$item['idProvincia']){
	                        echo "<option value='$fila[idProvincia]' selected> $fila[nombreProvincia]</option>";
                        }else {
	                        echo "<option value='$fila[idProvincia]'> $fila[nombreProvincia]</option>";
                        }
                    }
                    ?>
                </select>
            </p>

            <p>
                <label for="fNacimiento">Fecha Nacimiento:</label>
                <input type="date" name="fNacimiento" id="fNacimiento" value="<?=$item['fechaNacimiento']?>">
            </p>
        </div>

    </div>
    <div class="enviarBoton">
        <input type="submit" name="enviarFormulario1" value="↪ Actualizar" class="boton">
        <p class="error">
            <?php
            if (!empty($_GET["errores"])) {
                echo $_GET["errores"];
            }
            ?>
        </p>
    </div>

</form>
<?php
	}
        }else{
        echo "No puede entrar";
}
?>
</body>
</html>
