<!DOCTYPE html>
<html>
<head>
	<title>
		
	</title>
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


if(isset($_GET['tipoVehiculoEliminar'])){

			$tipoVehiculoEliminar=$_GET['tipoVehiculoEliminar'];
			$resultado=$bd->query("SELECT * from reserva,vehiculo where reserva.patente=vehiculo.patente and  vehiculo.id_tipovehiculo='$tipoVehiculoEliminar' and estado=1");
			$resultado=$bd->row();
			if($resultado>0){// distinto de null
				//el tipo de vehiculo esta en uso ERROR
				$base=0;
				

			}else{

				$resul=$bd->query("SELECT id_tarifa from tipo_vehiculo where id_tipovehiculo='$tipoVehiculoEliminar'");
				$resul=$bd->fetch();
				$id_tarifa=$resul['id_tarifa'];
								$valor=$bd->query("UPDATE tipo_vehiculo
								SET activo = 0
								WHERE id_tipovehiculo='$tipoVehiculoEliminar'");
				$valor=$bd->query("UPDATE tarifa
								SET activo = 0
								WHERE id_tarifa='$id_tarifa'");
				$base=1;
			}

				
		if($base==0){
		    $_SESSION['error_message'] = 'El tipo de vehiculo se encuentra en uso.';
		    Header("Location: tipoVehiculoMain.php");  
		}else if($base == 1){
		    $_SESSION['success_message'] = 'Tipo de vehiculo eliminado.';  
		    Header("Location: tipoVehiculoMain.php");
		}else{
		    $_SESSION['error_message'] = 'Ocurrio un error, Vuelve a intentarlo mas tarde.';
		    Header("Location: tipoVehiculoMain.php");  
		}
}

	 ?>

</body>
</html>