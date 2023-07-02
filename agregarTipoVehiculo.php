


<?php    
session_start();
if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: index.php");
    exit(1);
}

include 'BD.php';

$bd=new base();
$bd->conectar();




$nombre = $_POST["nombre"];
$tamanio = $_POST["tamanio"];

    

if (empty($nombre) || empty($tamanio)) {
header("Location: pages/tipoVehiculoMain2.php");
$_SESSION['error_message'] = "Debes completar todos los campos.";
}else{
    $valor = $bd->query("INSERT INTO tarifa (`id_tarifa`, `hora`, `6horas`, `12horas`, `24horas`, `semana`, `mes`,`activo`) VALUES ('', 0, 0, 0, 0, 0, 0,1)");

    if($valor){

        //obtengo el id de el ULTIMO tipo de tarifa agregado
        $valor=$bd->query("SELECT  MAX(id_tarifa)  as maximo from tarifa where activo=1;");
        $valor=$bd->fetch();
        $id_tarifa=$valor['maximo'];
        $valor = $bd->query("INSERT INTO `tipo_vehiculo`(`id_tipovehiculo`, `nombre`, `tamanio`, `id_tarifa`,`activo`) VALUES ('', '$nombre', '$tamanio', '$id_tarifa',1)");
        $valor=true;

    }else{
        $valor=false;
    }
        if($valor){
         
         $_SESSION['success_message'] = 'Exito al crear usuario.';
            header("Location: pages/tipoVehiculoMain2.php");
                 
        }else{
            $_SESSION['success_message'] = 'Error al crear el vehiculo';
                    header("Location: pages/tipoVehiculoMain2.php"); 
        }



}





 ?>
