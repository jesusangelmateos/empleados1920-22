<?php
require 'funciones.php';

$conn=conectarBD();
if (!isset($_POST) || empty($_POST)) { 

    /*Función que obtiene los empleados de la empresa*/
    $empeleado = obtenerEmpleados($conn);
    /*Función que obtiene los departamentos de la empresa*/
    $departamentos = obtenerDepartamentos($conn);

	echo '<form action="" method="post"';
?>
<h1>CAMBIO EMPLEADO</h1><br><br>
	<div>
	DNI <select name="empleado">
	<?php foreach($empeleado as $empeleado) : ?>
				<option> <?php echo $empeleado ?> </option>
			<?php endforeach; ?></select><br><br>
    </div>
    Departamentos <select name="departamento">
	<?php foreach($departamentos as $departamentos) : ?>
				<option> <?php echo $departamentos ?> </option>
			<?php endforeach; ?></select><br><br>
    </div>
    
    <?php
	echo '<div><input type="submit" value="Cambio de Departamento"></div>
		</form>'; 
}

else{
    $fechaAlta=date("Y-m-d H:m:s");//La fecha actual
    $nomDep=$_POST['departamento'];
    
    $sql="SELECT cod_dpto from departamento where nombre='$nomDep'";
    $resultado=mysqli_query($conn, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);
    $cod_dpto=$row['cod_dpto'];
    
    $dni=$_POST['empleado'];
    $sql = "UPDATE emple_depart set cod_dpto='$cod_dpto', fecha_fin='$fechaAlta' where dni=' $dni'";
    mysqli_query($conn, $sql);
    $sql="INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) VALUES ('$dni', '$cod_dpto', '$fechaAlta')";


	if(mysqli_query($conn, $sql)){

		echo "Empleado cambiado correctamente<br>";
	}
	else{
		echo "error: " .$sql."<br>".mysqli_error($conn);
	}

}
?> 