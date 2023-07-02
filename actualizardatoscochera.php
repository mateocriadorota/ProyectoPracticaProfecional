<?php
session_start();
if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: index.php");
    exit(1);
}


require_once("BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

$id=$_POST['id'];
$ubicacion=$_POST['ubicacion'];
$tamanio=$_POST['tamanio'];

$query = "UPDATE cochera SET ubicacion='$ubicacion',tamaniomax='$tamanio' WHERE id_cochera ='$id'";
$resultado = $base->query($query);

if($resultado)
    Header("Location: ./pages/gestioncochera.php");
?>