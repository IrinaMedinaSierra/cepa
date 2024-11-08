<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Gestion de Alumnos matriculados</h1>
<div class="mas">
    <form action="../controlador/controlador.php?opcion=buscar" class="opciones">
        <input type="search" placeholder="Buscar" maxlength="20">
        <input type="submit" class="botonOpciones" value="✓">
    </form>
   <a href="formulario1.php" class="botonOpciones">✚</a>
</div>
<div class="formulario">
	<table>
		<tr>
			<th>NºID</th>
			<th>Nombre</th>
			<th>P. Apellido</th>
			<th>S. Apellido</th>
			<th>DNI</th>
			<th>Telefono</th>
			<th>Acciones</th>
		</tr>
		<?php
			include_once("../modelo/conexion.php"); //invocamos el archivo que carga la BBDD
			$link = conectar();
                $consulta="select * from alumno";
                $resultado=mysqli_query ($link,$consulta);
               while ($fila = mysqli_fetch_assoc($resultado)){
                   echo "<tr>
                    <td>$fila[idAlumno]</td>
                    <td>$fila[nombre]</td>
                    <td>$fila[primerApellido]</td>
                    <td>$fila[segundoApellido]</td>
                    <td>$fila[dni]</td>
                    <td>$fila[telefono]</td>
                    <td>
                    <a href='../controlador/controlador.php?opcion=borrar&origen=crud&id=$fila[idAlumno]&idFamiliar=$fila[idFamiliar]' class='botonOpciones' title='Eliminar Alumno'>✖︎</a>
                      
                      
                      <a href='modificarA.php?opcion=modificar&origen=crud&id=$fila[idAlumno]' class='botonOpciones' title='Actualizar Alumno'>︎︎✍︎︎︎</a>
                      <a href='modificarF.php?opcion=modificarF&origen=crud&idFamiliar=$fila[idFamiliar]' class='botonOpciones' title='Actualizar Familiar'>✍︎︎︎✍︎</a>
                    </td>
                    </tr>";
                }
            ?>
		
	</table>
	
	</div>


</body>
</html>

