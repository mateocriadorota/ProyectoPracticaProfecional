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

$uso=$base->query("SELECT * FROM reserva WHERE '$id'=id_cochera and  estado = 1");
if($base->row()>0){
    $base=0;
}else{
	$valor=$base->query("UPDATE cochera
									SET activo = 0
									WHERE id_cochera='$id'");
	$base=1;
}

if($base==0){
    $_SESSION['error_message'] = 'La cochera se encuentra en uso.';
    Header("Location: ./pages/gestioncochera.php");  
}else if($base == 1){
    $_SESSION['success_message'] = 'Cochera eliminada.';  
    Header("Location: ./pages/gestioncochera.php");
}else{
    $_SESSION['error_message'] = 'Ocurrio un error, Vuelve a intentarlo mas tarde.';
    Header("Location: ./pages/gestioncochera.php");  
}


?>