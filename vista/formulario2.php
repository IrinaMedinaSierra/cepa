<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CEPA</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/formulario2.js"></script>
</head>
<body>
<h1>Formulario de Alta de nuevo Alumno</h1>
<h2 class="centrado">2️⃣⇢ Datos de persona Contacto</h2>
<form action="../controlador/controlador.php" method="post">
    <input type="hidden" name="origen" value="formulario2">
    <div class="formulario unaColumna">
        <div>
            <p>
                <label for="nombreFamiliar">Nombre persona Contacto:</label>
                <input type="text" name="nombreFamiliar" id="nombreFamiliar">
            </p>
            <p>
                <label for="telefonoFamiliar">Teléfono del Contacto:</label>
                <input type="text" name="telefonoFamiliar" id="telefonoFamiliar">
            </p>
            <p>
                <label for="relacion">Relación:</label>
                <select name="relacion" id="relacion">
                    <option value=""></option>
                    <?php
                    include_once("../modelo/conexion.php"); //invocamos el archivo que carga la BBDD
                    $link = conectar();//ejecutas la funcion conectar()
                    $consulta = "SELECT * FROM parentesco"; //se guarda en una variable la consulta
                    $resultado = mysqli_query($link, $consulta);//se ejecuta la consulta
                    while ($fila = mysqli_fetch_assoc($resultado)) { //recorrer el array y guardar en $fila que es cada
                        //registro asociado a cada campo-> ej: $fila["idEstudios"]   / $fila["nombreNivel"]
                        echo "<option value='$fila[idRelacion]'> $fila[nombreRelacion]</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
            <input type="checkbox" id="casilla">Acepta la Política de <a  href="https://aepd.es/" target="_blank">Privacidad y Protección de Datos</a>
            </p>
        </div>
    </div>
    <div class="enviarBoton">
        <input type="submit" name="enviarFormulario2" value="↪ Finalizar" disabled id="enviarFormulario2" class="botonDesactivado">
        <p class="error">
            <?php
            if (!empty($_GET["errores"])) {
                echo $_GET["errores"];
            }
            ?>
        </p>
    </div>
</form>
</body>
</html>
