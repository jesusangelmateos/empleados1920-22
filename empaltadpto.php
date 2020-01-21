<HTML>
<HEAD>
</HEAD>
<BODY>
<?php
require "funciones.php";
$nombreDep=limpiar_campo($_REQUEST['nombreDep']);



// Create connection
$conn = conectarBD();

// Check connection
if (!$conn) {
    die("Conexion fallida: " .mysqli_connect_error());
}

$resultMax="select max(cod_dpto) from departamento";
$result = mysqli_query($conn, $resultMax);
//print_r($result);
$CodNuevo="";

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       //echo "Codigo dpto: " . $row["max(cod_dpto)"]."<br>";
        $maxCod=$row["max(cod_dpto)"];
        $CodNuevo=substr($maxCod, 1);
        settype($CodNuevo,'integer');
        $CodNuevo=$CodNuevo+1;
        $CodNuevo=str_pad($CodNuevo, 3, "0", STR_PAD_LEFT);
        $CodNuevo="D".$CodNuevo;
        //echo $CodNuevo;
    }
} else {
    $CodNuevo="D001";
}

$insert = "INSERT INTO departamento (cod_dpto, nombre) values ('$CodNuevo','$nombreDep')";
if (mysqli_query($conn, $insert)) {
    echo "Registro Creado";
} else {
    echo "Error: " . $insert . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

?>
</BODY>	 
</HTML>	