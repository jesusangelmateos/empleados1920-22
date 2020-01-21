<?php
require 'funciones.php';

$conn=conectarBD();
if (!isset($_POST) || empty($_POST)) { 

    /*Función que obtiene el DNI de los empleados de la empresa*/
	$departamentos = obtenerDepartamentos($conn);

	echo '<form action="" method="post"';

	?>
	<h1>ALTA EMPLEADO</h1><br><br>
	<div>
	DNI <input type='text' name='dni' value=''><br><br>
	Nombre <input type='text' name='nombre' value=''><br><br>
	Apellidos <input type='text' name='apellidos' value=''><br><br>
	Fecha de nacimiento <input type='text' name='fechaNac' value=''><br><br>
	Salario <input type='text' name='salario' value=''><br><br>
	Fecha de alta <input type='text' name='fechaAlta' value=''><br><br>
	Departamento<select name="departamento">
	<?php foreach($departamentos as $departamento) : ?>
				<option> <?php echo $departamento ?> </option>
			<?php endforeach; ?></select><br><br>
	</div>

	<?php
	echo '<div><input type="submit" value="Alta Empleado"></div>
		</form>'; 
}

else{
	set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores
	$dni=limpiar_campo($_REQUEST['dni']);
	if($dni==""){
		trigger_error('El campo no puede estar vacio');	
	}
	$nombre=limpiar_campo($_REQUEST['nombre']);
	if($nombre==""){
		trigger_error('El campo no puede estar vacio');	
	}
	$apellidos=limpiar_campo($_REQUEST['apellidos']);
	if($apellidos==""){
		trigger_error('El campo no puede estar vacio');	
	}
	$fechaNac=limpiar_campo($_REQUEST['fechaNac']);
	if($fechaNac==""){
		trigger_error('El campo no puede estar vacio');	
	}
	$salario=limpiar_campo($_REQUEST['salario']);
	if($salario==""){
		trigger_error('El campo no puede estar vacio');	
	}
	$fechaAlta=limpiar_campo($_REQUEST['fechaAlta']);
	if($fechaAlta==""){
		trigger_error('El campo no puede estar vacio');	
	}

	$sql = "INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario) VALUES ('$dni', '$nombre', '$apellidos', '$fechaNac', '$salario')";
	if(mysqli_query($conn, $sql)){

		echo "Empleado insertado correctamente<br>";
	}
	else{
		echo "error: " .$sql."<br>".mysqli_error($conn);
	}
	$departamento=$_POST['departamento'];
	$sql = "SELECT cod_dpto FROM departamento WHERE nombre= '$departamento'";
	$resultado=mysqli_query($conn, $sql);//el resultado no es valido, hay que tratarlo
	$row=mysqli_fetch_assoc($resultado);
	$codigo=$row['cod_dpto'];
	$sql = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) VALUES ('$dni', '$codigo', '$fechaAlta')";
	if(mysqli_query($conn, $sql)){
		
		echo "Empleado insertado en emple_depart";
	}
	else{
		echo "error: " .$sql."<br>".mysqli_error($conn);
	}
	
}

?>