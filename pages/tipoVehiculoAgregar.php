<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php 	 
session_start();
if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
   	header("Location: index.php");
    exit(1);
}

include '../BD.php';

$bd=new base();
$bd->conectar();


if(isset($_GET['nombre'])){

			$nombre=$_GET['nombre'];
			$tamanio=$_GET['tamanio'];
			
			$valor = $bd->query("INSERT INTO tarifa (`id_tarifa`, `hora`, `6horas`, `12horas`, `24horas`, `semana`, `mes`,`activo`) VALUES ('', 0, 0, 0, 0, 0, 0,1)");

			if($valor){

				//obtengo el id de el ULTIMO tipo de tarifa agregado
				$valor=$bd->query("SELECT id_tarifa FROM tarifa WHERE hora=0 and semana=0 and mes=0 and activo=1");
				$valor=$bd->fetch();
				$id_tarifa=$valor['id_tarifa'];
				$valor = $bd->query("INSERT INTO `tipo_vehiculo`(`id_tipovehiculo`, `nombre`, `tamanio`, `id_tarifa`,`activo`) VALUES ('', '$nombre', '$tamanio', '$id_tarifa',1)");
				$valor=true;

			}else{
				$valor=false;
			}
				if($valor){
				 
				 echo "<script type='text/javascript'>
						alert('AGREGADO CON EXITO');
						window.location.href = 'tipoVehiculoMain.php';
						</script>";
						 
				}else{
					echo "<script type='text/javascript'>
						alert('ERROR');
						window.location.href = 'tipoVehiculoMain.php';
						</script>"; 
				}
}else{
echo '<form method="get" action="' . $_SERVER['PHP_SELF'] . '">
	<label>Tipo de vehiculo</label>
	<input type="text" name="nombre"><br>
	<label>Tamanio</label>
	<input type="text" name="tamanio"><br>
	<input type="submit" value="agregar">
</form>
 <form method="get" action="tipoVehiculoMain.php">
 	<input type="submit" value="volver">
 </form>
';






}
 ?>
</body>
</html>