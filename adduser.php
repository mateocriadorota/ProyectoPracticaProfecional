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

$nombre = $_POST["nombre"];
$usuario = $_POST["usuario"];
$apellido = $_POST["apellido"];
$password = $_POST["password"];

// Verifica si se ha enviado el formulario de agregar empleado
if (empty($nombre) || empty($apellido) || empty($usuario) || empty($password)) {
    header("Location: pages/users.php");
    $_SESSION['error_message'] = "Debes completar todos los campos.";
}else{

    // Realiza la inserción del empleado en la tabla "empleado"
    $query = "INSERT INTO empleado (nombre, apellido, password, username, id_rol,activo) VALUES ('$nombre', '$apellido', '$password', '$usuario', 1,1)";
    $result = $base->query($query);
    if($result == 1){
        $_SESSION['success_message'] = 'Exito al crear usuario.';
        header("Location: pages/users.php");
    }
}
?>