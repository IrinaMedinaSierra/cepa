<?php
	session_start();
	if (empty($_SESSION["nombreCompleto"])){
		header("Location: formulario1.php?errores=Debe completar ambos formularios. Acceso DENEGADO");
	}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>CEPA</title>
</head>
<body>
<h1>Formulario de Alta de nuevo Alumno</h1>
<h2 class="centrado">3️⃣⇢ Alta Confirmada</h2>
<div class="formulario unaColumna">
    <div>
        <p>Le informamos que el alta al sistema de Inscripcion del CENTRO DE EDUCACION  PARA ADULTOS se ha realizado
            con exito</p>
        <p>Sus datos son:</p>
        <ul>
            <li>Nombre: <?=$_SESSION["nombreCompleto"]?></li>
            <li>Telefono: <?=$_SESSION["telefono"] ?></li>
        </ul>
        <p>Nota: Su numero de registro es: <span class="error"><?=$_SESSION["idRegistro"]?></span></p>
    </div>


</div>

</body>
</html>