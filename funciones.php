<?php

//Funcion para conectar a una BD
function conectarBD(){
    $servername='localhost';
    $username='root';
    $password='rootroot';
    $dbname='empleados22';
    $conn=mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        trigger_error("Conexion Fallida: ".mysqli_connect_error()."<br>");
    }
    echo "Conexion Realizada <br>";
    return $conn;
}

function desconectarBD($conn){
    echo "Desconexion realizada";
    mysqli_close($conn);
}

// Obtengo todos los departamentos para mostrarlos en la lista de valores
function obtenerDepartamentos($conn) {
	$departamentos = array();
	
	$sql = "SELECT cod_dpto,nombre FROM departamento";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre'];
		}
	}
	return $departamentos;
}

// Obtengo todos los empleados para mostrarlos en la lista de valores
function obtenerEmpleados($conn){
    $empleados = array();

    $sql = "SELECT dni FROM empleado";

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['dni'];
		}
	}
	return $empleados;
}

//funcion que recibe un campo y limpia lo limpia
//parametros: campo
//devuelve el campo limpio
function limpiar_campo($campoformulario) {
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);  
    return $campoformulario;
}

//funcion de gestion de errores, da informacion y acaba procesos
//parametros	$error_level -> codigo del error
//				$error_message -> mensaje de error
//				$error_file -> fichero del error
//				$error_line -> linea del error
//				$error_context -> array multidimensional con todo el contenido
//no devuelve nada

function errores ($error_level, $error_message, $error_file, $error_line, $error_context){
	echo "<b>Codigo error: </b> $error_level - <b> Mensaje: $error_message </b><br>";
	echo "<b>Fichero: $error_file</b><br>";
	echo "<b>Linea: $error_line</b><br>";
	//var_dump($error_context);
	echo "Finalizando script <br>";
	die(); 
//set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores
//trigger_error('El DNI '.$DNI.' ya existe previamente');	
}
?>