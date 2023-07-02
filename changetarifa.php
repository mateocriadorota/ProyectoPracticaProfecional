
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>



<?php  

//archivo que edita, elimina o agrega tarifas
if(session_status() != 2)
    session_start();
if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: pages/index.php");
    exit(1);
}

// Incluye el archivo que contiene la clase "base"
require_once("BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

//poner varibles post enviadas
if(isset($_POST['hora'])){


	$id=$_POST['id'];
	echo $id;
	$hora=$_POST['hora'];
	$seisHoras=$_POST['6horas'];
	$doceHoras=$_POST['12horas'];
	$vcuatroHoras=$_POST['24horas'];
	$semana=$_POST['semana'];
	$mes=$_POST['mes'];
	$queryTarifa = "UPDATE tarifa 
                SET hora = '$hora',
                `6horas` = '$seisHoras',
                `12horas` = '$doceHoras',
                `24horas` = '$vcuatroHoras',
                semana = '$semana',
                mes = '$mes'
                WHERE id_tarifa = '$id'";
	$respuestaTarifa = $base->query($queryTarifa);
	if($respuestaTarifa){
		//exitoso
		header("Location:pages/tarifa.php");

	}else{
		echo "fallo";
	}

}


?>












</body>
</html>




