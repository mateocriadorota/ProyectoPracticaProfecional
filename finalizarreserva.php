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
    // Verificar que las variables no estén vacías
	var_dump($_POST);
    if (!empty($_POST["patente"]) && !empty($_POST["idcochera"]) && !empty($_POST["codigo_reserva"]) && !empty($_POST["hsentrada"]) && !empty($_POST["hsalida"]) && !empty($_POST["metodopago"])) {
        // Variables no vacías, puedes acceder a ellas aquí
        $patente = $_POST["patente"];
        $idcochera = $_POST["idcochera"];
        $codigo_reserva = $_POST["codigo_reserva"];
       // $hsentrada = new DateTime($_POST["hsentrada"]);
        $metodopago = $_POST["metodopago"];
		$hsalida = ($_POST["hsalida"]);
		$idusuario = $_SESSION["codigo_empleado"];
		$montofinal = $_POST["monto"];


		//pone el estado de la reserva en 0.
		$valor=$bd->query("UPDATE reserva SET estado = 0 WHERE codigo_reserva = $codigo_reserva");
		if($valor != 1){
			$_SESSION['error_message'] = 'Ocurrio un problema al procesar al salida.';  
			Header("Location: ./pages/salidavehiculo.php");
			exit();
		}

	   
		
		//inserta el resumen en la tabla factura.
		$valor = $bd->query("INSERT INTO factura (horario_salida, monto, id_tipopago, cod_empleado, cod_reserva) VALUES ('$hsalida', '$montofinal', $metodopago, '$idusuario', '$codigo_reserva')");
		if($valor != 1){
			$_SESSION['error_message'] = 'Ocurrio un problema al procesar al salida.';  
			Header("Location: ./pages/salidavehiculo.php");
			exit();

		}
		$valor = $bd->query("SELECT id_factura FROM factura  WHERE '$codigo_reserva'=cod_reserva");
		$valor=$bd->fetch();
		$id_factura=$valor['id_factura'];
		

		$_SESSION['success_message'] = 'Salida procesada con exito.';  
		//Header("Location: ./pages/salidavehiculo.php");
		
			        header('Location: pages/generaFactura2.php?id_factura=' . $id_factura . '&metodopago=' . $metodopago);


       
    } else {
        // Alguna de las variables está vacía, muestra un mensaje de error o realiza alguna acción
        echo "Error: Todos los campos son obligatorios";
    }
}
?>
