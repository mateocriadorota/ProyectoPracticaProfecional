<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 

session_start();
if(!isset($_SESSION['islogged'])) {
    header("Location: index.php");
    exit(1);
}

// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

$cod_empleado = $_SESSION["codigo_empleado"];
//se busca todas las ids de los tipos de pago
 $arrayTipoPago=$base->query("SELECT * from tipo_pago");
 //se obtiene todos los id de estos en un array
 $arrayTipoPago=$base->fetchAll();
 //se recorre el array de tipos de pagos
 foreach($arrayTipoPago as $tipoPago){
 	 
 	$id_tipopago=$tipoPago['id_tipopago'];
 	//cada una se utiliza para una query en donde se suma el total 
 	//de la plata facturada en ese tipo de pago durante las ultimas 13 horas
 	$total=$base->query("SELECT SUM(monto) as suma from factura where id_tipopago='$id_tipopago' and cod_empleado='$cod_empleado' and horario_salida >= DATE_SUB(NOW(), INTERVAL 18 HOUR);");
 	//se trae la la fila, en SUMA tento el total
 	$total=$base->fetch();
 	//imprimo valores
 	echo $tipoPago['nombre'];
 	echo $total['suma'];
 	echo "<br>";

 }


 //$valor=$bd->query("SELECT * FROM factura WHERE cod_empleado='$cod_empleado'");
 ?>










	

</body>
</html>