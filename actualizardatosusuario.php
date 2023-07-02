<?php
session_start();

if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: pages/index.php");
    exit(1);
}

require_once("BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$usuario=$_POST['usuario'];
$pass=$_POST['pass'];

$query = "UPDATE empleado SET nombre='$nombre',apellido='$apellido', username='$usuario',password='$pass' WHERE cod_empleado ='$id' and activo=1";
$resultado = $base->query($query);

if($resultado == 1){
    $_SESSION['success_message'] = 'Usuario editado.';  
    Header("Location: ./pages/users.php");
}else{
    $_SESSION['error_message'] = 'Ha ocurrido un error, intentelo mas tarde.';  
    Header("Location: ./pages/users.php");
}
?>