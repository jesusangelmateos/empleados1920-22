<?php
require 'funciones.php';

$conn=conectarBD();
if (!isset($_POST) || empty($_POST)) { 

    /*Función que obtiene los departamentos de la empresa*/
    $departamentos = obtenerDepartamentos($conn);

	echo '<form action="" method="post"';
?>
<h1>LISTA EMPLEADOS</h1><br><br>
	<div>
	
    Departamentos <select name="departamento">
	<?php foreach($departamentos as $departamentos) : ?>
				<option> <?php echo $departamentos ?> </option>
			<?php endforeach; ?></select><br><br>
    </div>
    
    <?php
	echo '<div><input type="submit" value="Lista"></div>
		</form>'; 
}
else{
    $nomDep=$_POST['departamento'];
    $sql="SELECT cod_dpto from departamento where nombre='$nomDep'";
    $resultado=mysqli_query($conn, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);
    $cod_dpto=$row['cod_dpto'];
    $dnis=array();

    $sql="SELECT dni  from emple_depart where cod_dpto='$cod_dpto' AND fecha_fin IS NULL";
    $resultado=mysqli_query($conn, $sql);//el resultado no es valido, hay que tratarlo
    if ($resultado) {
        // output data of each row
        while($row = mysqli_fetch_assoc($resultado)) {
            $dnis[]=$row['dni'];
        }
    }
    if(count($dnis)==0){
        echo 'El Departamento esta vacio';
    }
    else{
        foreach($dnis as $dni){
            $sql="SELECT empleado.*, emple_depart.* FROM empleado, emple_depart WHERE empleado.dni=emple_depart.dni AND emple_depart.dni='$dni'";
            $resultado=mysqli_query($conn, $sql);//el resultado no es valido, hay que tratarlo
            $row=mysqli_fetch_assoc($resultado);
            $dniEmp=$row['dni'];
            $nomEmp=$row['nombre'];
            $apeEmp=$row['apellidos'];
            $cod=$row['cod_dpto'];
            $fechaIni=$row['fecha_ini'];
            echo "DNI: ".$dniEmp." Nombre: ".$nomEmp." Apellidos: ".$apeEmp;
        }
    }
    
}
?>