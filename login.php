<?php
	session_start();
	include 'BD.php';
	$bd = new base();
	$bd->conectar();
	
	if(isset($_POST['usuario']) && isset($_POST['pass'])){


		$usuario = $_POST['usuario'];
		$pass = $_POST['pass'];

		if(empty($pass) || empty($usuario)) {
			$_SESSION['error_message'] = "Debes completar todos los campos.";
			header("Location: pages/login.php");
			exit;
		}

		$valor = $bd->query("SELECT * FROM empleado WHERE password = '$pass' AND username = '$usuario'");
		$valor = $bd->fetch();

		// declaramos una variable para luego verificar que esta logeado y corroboramos su rol.
		if($bd->row()>0) {  
			
			if($valor["id_rol"] == 2){
				$_SESSION['isadmin'] = true;
			}
			if($valor['activo']==1&&$valor['id_rol'] == 1||$valor['id_rol'] == 2	){


			$_SESSION["islogged"] = true;
			$_SESSION['codigo_empleado'] = $valor['cod_empleado'];
			$_SESSION['usuario'] = $valor['nombre'];
			header("Location: pages/index.php");
			}else{
				$_SESSION['error_message'] = "Usuario o contraseña incorrectos";
			header("Location: pages/login.php"); // Redireccionar a la página correspondiente
			exit();
			}
		} else {
			$_SESSION['error_message'] = "Usuario o contraseña incorrectos";
			header("Location: pages/login.php"); // Redireccionar a la página correspondiente
			exit();
		}
	}
?>


