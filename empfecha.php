<?php
require 'funciones.php';

$conn=conectarBD();
if (!isset($_POST) || empty($_POST)) { 

    /*Función que obtiene los empleados de la empresa*/
    $empleados = obtenerEmpleados($conn);

	echo '<form action="" method="post"';
?>
<h1>FECHA</h1><br><br>
	<div>
	Fecha <input type='date' name='fecha' value=''>
    </div>
    
    <?php
	echo '<div><input type="submit" value="Mostrar"></div>
		</form>'; 
}
else{
    set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores
    $fecha=strtotime($_REQUEST["fecha"]);
	$fecha=date("Y-m-d", $fecha);
	if($fecha==''){ 
		trigger_error('La fecha no puede estar vacia');	
    }
    $sql="SELECT empleado.dni, departamento.cod_dpto from empleado, departamento, emple_depart where empleado.dni=emple_depart.dni and departamento.cod_dpto=emple_depart.cod_dpto and fecha_ini='$fecha' and fecha_fin is null";
    $resultado=mysqli_query($conn, $sql);

    if ($resultado) {
        while ($row = mysqli_fetch_assoc($resultado)) {
          $dni_emp=$row['dni'];
          $cod_dpto=$row['cod_dpto'];
          ?><pre><?php
          echo "EMPLEADO: ".$dni_emp.", DEPARTAMENTO=".$cod_dpto."</br>";
          ?></pre><?php    
        }
    }
  
    echo 'Lista generada';
}
?>