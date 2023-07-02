<?php
session_start();
if(!isset($_SESSION['islogged']) ) {
    header("Location: pages/index.php");
    exit(1);
}
include("BD.php");
$bd = new base();
$bd->conectar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patente = $_POST["patente"];
    $dni = ($_POST["dni"]) ;
    $tipovehiculo = $_POST["tipovehiculo"];
    $cochera = $_POST["cochera"];
    $idempleado = $_SESSION["codigo_empleado"];
   // date_default_timezone_set('America/Argentina/Buenos_Aires');
    $horaEntrada= $_POST["hsentrada"];

   if (empty($patente) || empty($tipovehiculo) || empty($cochera)) {
        $_SESSION['error_message'] = "Debes completar todos los campos.";
        header("Location: pages/entradavehiculo.php");
        exit();
    }
         else {

        $valor = $bd->query("SELECT * FROM reserva WHERE patente = '$patente' and estado=1");
        // Verificar si se encontraron resultados
        if (($bd->res->num_rows > 0)) {


            
                $_SESSION['error_message'] = "Hay un Auto con la misma patente en el establecimiento";
                header("Location: pages/entradavehiculo.php");
                exit();
             
        }

        //verificamos si no existe el vehiculo con patente
        $valor = $bd->query("SELECT * FROM vehiculo WHERE patente = '$patente'");
        // Verificar si se encontraron resultados
        if (!($bd->res->num_rows > 0)) {






             //si no existe lo carga
             $valor=$bd->query("INSERT INTO `vehiculo`(`patente`, `id_tipovehiculo`) VALUES ('$patente','$tipovehiculo')");
             if($valor != 1){
                $_SESSION['error_message'] = "Ha ocurrido un error al crear la reserva." . $valor;
                header("Location: pages/entradavehiculo.php");
                exit();
             }
        }else{


            $valor=$bd->query("UPDATE `vehiculo` SET `id_tipovehiculo`='$tipovehiculo' WHERE patente = '$patente' ");
            

        }

        if($dni != null){
            // Ejecutar la consulta
            $valor = $bd->query("SELECT * FROM cliente WHERE dni = '$dni'");

            // Verificar si se encontraron resultados
            if (!($bd->res->num_rows > 0)) {
                //si no existe lo carga
                $valor=$bd->query("INSERT INTO cliente VALUES (0, '$dni')");
                if($valor != 1){
                    $_SESSION['error_message'] = "Ha ocurrido un error al crear la reserva." . $valor;
                    header("Location: pages/entradavehiculo.php");
                    exit();
                 }
            }

            $valor=$bd->query("SELECT * FROM cliente WHERE dni = '$dni'");
            $valor=$bd->fetch();
            $codcliente = $valor['id_cliente'];

        }else{
            $codcliente=null;
        }

        $valor=$bd->query("INSERT INTO `reserva`  VALUES (0,'$horaEntrada','1','$cochera','$codcliente','$patente','$idempleado')");
        if($valor != 1){
            $_SESSION['error_message'] = "Ha ocurrido un error al crear la reserva." . $valor;
            header("Location: pages/entradavehiculo.php");
            exit();
         }

        $valor=$bd->query("SELECT * FROM reserva WHERE patente = '$patente' AND estado = 1");
        $valor=$bd->fetch();
        $codreserva = $valor['codigo_reserva'];


        $_SESSION['success_message'] = "Se ha creado una nueva cochera con el codigo de reserva N." . $codreserva;
        //header("Location: pages/generaFactura.php");
        //header("pages/generaFactura.php?codigo_reserva=".$codreserva);

        //header("Location:  generaFactura.php?codigo_reserva=".$codreserva);

           
                  header('Location: pages/generaFactura2.php?codigo_reserva=' . $codreserva );
                  


    }
}
?>