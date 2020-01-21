<?php
require 'funciones.php';

$conn=conectarBD();
if (!isset($_POST) || empty($_POST)) { 

    /*Función que obtiene los empleados de la empresa*/
    $empleados = obtenerEmpleados($conn);

	echo '<form action="" method="post"';
?>
<h1>SALARIO EMPLEADOS</h1><br><br>
	<div>
	Incremento/Decremento Salario en % <input type='number' name='salario' value=''><br><br>
    Empleado <select name="empleado">
	<?php foreach($empleados as $empleados) : ?>
				<option> <?php echo $empleados ?> </option>
			<?php endforeach; ?></select><br><br>
    </div>
    
    <?php
	echo '<div><input type="submit" value="Cambiar Salario"></div>
		</form>'; 
}
else{
    set_error_handler("errores"); // Establecemos la funcion que va a tratar los errores
    $dniEmp=limpiar_campo($_POST['empleado']);
    if($dniEmp==""){
		trigger_error('El empleado no puede estar vacio');	
	}
    $porcentaje=limpiar_campo($_POST['salario']);
    if($porcentaje==""){
		trigger_error('El porcentaje no puede estar vacio');	
	}

    $sql="SELECT salario FROM empleado WHERE dni='$dniEmp'";
    $resultado=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($resultado);
    $salario=$row['salario'];

    if($porcentaje[0]=="-"){ //negativo
        echo "negativo ";
        $porcentaje=substr($porcentaje, 1); //quitar el simbolo -  
        $salarioNuevo=$salario-($salario*($porcentaje/100));
    }
    else{
        echo "positivo ";  
        $salarioNuevo=$salario+($salario*($porcentaje/100));
    }
    $sql="UPDATE empleado set salario='$salarioNuevo' where dni='$dniEmp'";

    if (mysqli_query($conn, $sql)) {
        echo "Salario de empleado ".$dniEmp." cambiado a: ".$salarioNuevo."<br>";
    }
    else {
        echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
    }
  
    echo 'Salario Actualizado';
}
?>