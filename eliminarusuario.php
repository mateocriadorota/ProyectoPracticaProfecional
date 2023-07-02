<?php

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

$id=$_GET['id'];

//eliminando usuario

					$valor=$base->query("UPDATE empleado
								SET activo = 0
								WHERE cod_empleado='$id'");
					

			



if($valor == 1){
    $_SESSION['success_message'] = 'Usuario eliminado.';  
    Header("Location: ./pages/users.php");
}else{
    $_SESSION['error_message'] = 'Ocurrio un error, Vuelve a intentarlo mas tarde.' . $valor;
    header("Location: pages/users.php");    
}
?>