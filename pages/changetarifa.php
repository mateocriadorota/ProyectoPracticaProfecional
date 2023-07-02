<?php 

//archivo que edita, elimina o agrega tarifas
if(session_status() != 2)
    session_start();

if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: index.php");
    exit(1);
}
// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

//poner varibles post enviadas
//if(isset($_POST['']))

?>