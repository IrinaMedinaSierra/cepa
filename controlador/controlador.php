<?php
	session_start();
	/**
	 * Array de errores que se utiliza tanto en el formulario1 como en el formulario2
	 * Se inicializa cada vez que se llama el archivo controlador
	 */
	$errores=array();
	$todosLosErrores="";
	/**
	 * La siguiente condición lee desde donde se recibe el formulario y valida los campos importantes u obligatorios
	 * Si todo es correcto, envia al siguiente formulario
	 * En caso de error, se envia cuáles campos tienen error para su corrección.
	 */
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
			$_SESSION["insertarAlumno"]="insert into alumno (nombre, primerApellido, segundoApellido, dni, telefono, direccion,
                    cp, ciudad, fechaUltimoEst, idProvincia, idEstudios, fechaNacimiento) values
    (
     '".$_REQUEST["nombre"]."',
     '".$_REQUEST["pApellido"]."',
     '".$_REQUEST["sApellido"]."',
     '".$_REQUEST["dni"]."',
     ".$_REQUEST["telefono"].",
     '".$_REQUEST["direccion"]."',
     '".$_REQUEST["cp"]."',
     '".$_REQUEST["ciudad"]."',
     '".$_REQUEST["fechaUE"]."',
     ".$_REQUEST["provincia"].",
     ".$_REQUEST["uEstudio"].",
     '".$_REQUEST["fNacimiento"]."'
     )";
			header("Location:../vista/formulario2.php");
		}
	}
	/**
	 * La siguiente condición lee desde donde se recibe el formulario2 y valida los campos importantes u obligatorios
	 * Si todo es correcto, envia al siguiente formulario
	 * En caso de error, se envia cuáles campos tienen error para su corrección.
	 */
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
			require_once ("../modelo/conexion.php"); //llamamos a la conexión
			$link=conectar();
			$insertarFamiliar="insert into familiar (nombreFamiliar, telefono, idRelacion)
        values
            ('".$_REQUEST["nombreFamiliar"]."',
            ".$_REQUEST["telefonoFamiliar"].",
            ".$_REQUEST["relacion"]."
        )";
			$resultado=mysqli_query($link,$insertarFamiliar); //ejecuta la consulta
			$idFamiliar=mysqli_insert_id($link); //recupero el id del ultimo link que he insertado
			$insertarAlumno=$_SESSION["insertarAlumno"];
			$resultado=mysqli_query($link,$insertarAlumno);
			$idAlumno=mysqli_insert_id($link);
			$_SESSION["idRegistro"]=$idAlumno;
			$insertarFamiliarAlumno="update alumno set idFamiliar=".$idFamiliar." where idAlumno=".$idAlumno;
			$resultado=mysqli_query($link,$insertarFamiliarAlumno);
			/*Una vez insertado los datos del alumno y del familiar, puedo recuperar su nombre,apellido,telefono*/
			$consultaDatosAlumno="select nombre,primerApellido,telefono from alumno where idAlumno=".$idAlumno;
			$resultado=mysqli_query($link,$consultaDatosAlumno);
			$arrayAlumno[]=mysqli_fetch_assoc($resultado);
			foreach ($arrayAlumno as $alumno) {
				$_SESSION["nombreCompleto"]=$alumno["nombre"]." ".$alumno["primerApellido"];
				$_SESSION["telefono"]=$alumno["telefono"];
			}
			mysqli_close($link);//cierra la BBDD
			header("Location:../vista/confirmacion.php");
		}
		
		
	}
	/**
	 * @param $texto
	 * @param $variable
	 * @return void
	 * Función que valida cualquier texto, indicará un error en la variable globlal en caso de estar vacio o tener
	 * algún número
	 */
	function validarTexto($texto,$variable){
		global $errores;
		if (empty($texto) || !is_string($texto) || preg_match("/[0-9]/", $texto)) {// no es un string y tiene numeros
			$errores[]="<p>El $variable no puede ser vacio y ni contener numeros</p>";
		}
	}
	
	/**
	 * @param $valor
	 * @param $variable
	 * @return void
	 * Función que recibe un valor y su campo a la que hace referencia
	 * En caso de estar vacio, guarda en la variable global el mensaje de error haciendo referencia a su campo
	 * Ej: La ciudad no puede ser vacio
	 */
	function validarVacio($valor,$variable){
		global $errores;
		if  (empty($valor)){
			$errores[]="<p>$variable no puede ser vacio</p>";
		}
	}
	
	/**
	 * @param $telefono
	 * @return void
	 * Función que valida un número de telefono de España con 9 digitos y que comience con 6/7/8/9
	 * En caso de error guarda en la variable global el mensaje
	 */
	function validarTelefono($telefono)
	{
		global $errores;
		if(empty($telefono) || !is_numeric($telefono) || !preg_match("/^[6789]\d{8}$/",$telefono)){
			$errores[]="<p>El formato del telefono es incorrecto, debe comenzar por 6/7/8/9 y tener 9 digitos</p>";
		}
	}
	
	/**
	 * @param $fecha
	 * @return void
	 * @throws Exception
	 * Función que recibe la fecha de nacimiento y calcula con respecto a la fecha actual la edad del alumno
	 * En caso de no tener 18 años o mas, se guarda un error en la variable global que no puede ser menor de edad.
	 */
	function validarEdad($fecha)
	{
		global $errores;
		$fechaN = new DateTime($fecha); //la variable que se lee de la fecha de nacimiento creamos cmo tipo dateTime
		// Obtener la fecha actual
		$fecha_actual = new DateTime(); //leemos la fecha actual
		
		// Calcular la diferencia entre la fecha actual y la fecha de nacimiento
		$diferencia = $fecha_actual->diff($fechaN); //metodo que calcula la diferencia entre dos fechas en y-m-d h:m:s:
		
		// Obtener la edad en años
		$edad = $diferencia->y;
		if ($edad < 18) {
			$errores[] = "<p>Tienes $edad anios. La edad no puede ser menor a 18 anios</p>";
		}
	}
	
	/**
	 * @param $dni
	 * @return void
	 * Función que valida el dni con el formato y la letra correcta
	 * En caso de error, se guarda en la variable global si el error es de formato o de la letra
	 */
	function validarDni($dni){
		global $errores;
		if (preg_match("/^[0-9]{8}[A-Za-z]$/", $dni)) {//expresion regular que solo valida el formato del dni
			// Separar la letra del DNI
			$numero = substr($dni, 0, 8);
			$letra = strtoupper(substr($dni, -1));
			
			// Letras de control
			$letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
			
			// Calcular la letra correspondiente al número
			$indice = $numero % 23;
			$letra_correcta = $letras_validas[$indice];
			
			// Verificar si la letra coincide
			if ($letra_correcta != $letra){
				$errores[]="<p>DNI invalido (letra incorrecta)</p>"; // DNI inválido (letra incorrecta)
			}
		} else {
			$errores[]="<p>El DNI tiene formato incorrecto</p>";// Formato de DNI no válido
		}
	}
	
	/**
	 * @param $cp
	 * @return void
	 * Función que recibe un codigo postal y valida que sean 5 digitos, solo números
	 * En caso de error, guarda en la variable globla el mensaje.
	 */
	
	function validarCpostal($cp)
	{
		global $errores;
		if (empty($cp) || !preg_match("/^[0-9]{5}$/", $cp)) {
			$errores[] = "<p>El codigo postal no puede ser vacio y debe contener 5 numeros</p>";
		}
	}
	
	if ($_REQUEST["origen"]=="crud"){
		if ($_REQUEST["opcion"]=="borrar"){
			include_once "../modelo/conexion.php";
			$link=conectar ();
			echo "aqui llega";
			$id=$_REQUEST["id"];
			$idFamiliar=$_REQUEST["idFamiliar"];
			$consulta1="delete  from familiar where idFamiliar=$idFamiliar";
			$consulta2="delete  from alumno where idAlumno=".$id;
			echo $consulta2;
			echo "<br>$consulta1";
			$resultado2=mysqli_query ($link,$consulta2);
			$resultado1=mysqli_query ($link,$consulta1);
			if ($resultado2){
				//header ("Location:../vista/crud.php?msn=Registro $id eliminado con exito");
			}else{
				//header ("Location:../vista/crud.php?msn=Error al eliminar el registro $id ");
			}
		}
		
	}