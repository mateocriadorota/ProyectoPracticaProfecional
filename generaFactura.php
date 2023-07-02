

<!DOCTYPE html>
<html lang="en">

<?php 

echo 'Directorio actual: ' . __DIR__ . '<br>';
session_start();
if(!isset($_SESSION['islogged']) ) {
    header("Location: pages/index.php");
    exit(1);
}
ob_start();
require('libreria/barra/code128.php');

include 'BD.php';

$bd=new base();
$bd->conectar();

$cod_empleado=$_SESSION["codigo_empleado"];// aca se pone el codigo del empleado desde la variable de session

function change($date){
    $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $fechaCambiada =$fecha->format('d/m/Y H:i:s');
    return $fechaCambiada;

}

$directorio = 'pages';
if (chdir($directorio)) {
    echo 'Directorio cambiado correctamente';
} else {
    echo 'No se pudo cambiar el directorio';
}



 ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" con    tent="">
    <meta name="author" content="">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <title>Historial </title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="pages/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Cocheras</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="pages/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

    
            <!-- Heading -->
            <div class="sidebar-heading">
                Navegacion
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php require_once("navmenu.php") ?>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                 <!-- Sidebar Toggler (Sidebar)  <button class="rounded-circle border-0" id="sidebarToggle"></button>-->  
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once("topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between p-4">
                        <h1 class="h3 mb-2 text-gray-800">Vehículos Alojados</h1>
                    </div>
            
                        <?php
                            // Comprobar si hay mensajes de error almacenados en la sesión
                            if (isset($_SESSION['error_message'])) {
                                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                                unset($_SESSION['error_message']); // Eliminar el mensaje de error de la sesión
                            }

                            // Comprobar si hay mensajes de éxito almacenados en la sesión
                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); // Eliminar el mensaje de éxito de la sesión
                            }
                        ?>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></i>Reservas actuales del sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                    <!-- Datos traidos de la consulta $fila -->
                                   
<?php


if(isset($_GET['codigo_reserva'])){
	//$id_tipopago=$_GET['tipo_pago'];
	
	$codigo_reserva=$_GET['codigo_reserva'];
	
	$valor=$bd->query("SELECT * FROM reserva WHERE codigo_reserva='$codigo_reserva'");
	if($valor){
		$resultado=$bd->fetch();
		$patente=$resultado['patente'];
		$id_cochera=$resultado['id_cochera'];
		$hora_entrada=$resultado['hora_entrada'];
		
		//$codigoBarra=$resultado['codigoBarra'];
		//$resultado['']
		//date_default_timezone_set('America/Argentina/Buenos_Aires');
		//$horaSalida=date('Y-m-d H:i:s');//esta hora va a ser guardada

		//$monto=calculaMonto($horaEntrada,$horaSalida,$bd,$codigo_reserva);

		 //id tarifa no tendria que estar en rserva..
		 //tipo de pago debe aparecer en salidavehiculo.php

		// $horaSalidaFormatoArgentino=date('Y-m-d H:i:s');
		//esta fecha va a ser impresa

		$numero=1;
		
		
		$pdf=new PDF_Code128('P', 'mm', array(55, 120));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(28);
		$pdf->Cell(10,1,'GARAGE ');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(27);
		$pdf->Cell(40,5,' 24 HORAS');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,'---------------------------------------------');
		$pdf->Image('img/fotoAuto.png',2,4,20);
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,15,'TICKET DE ENTRADA');
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,0,change($hora_entrada));
		$pdf->Ln();
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',20);
		$pdf->SetX(7);
		$pdf->Cell(40,20,$patente);
		$pdf->Ln();
		
		$pdf->SetX(10);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,"Cochera no.  ".$id_cochera);
		$pdf->SetFont('Arial','B',7);
		
		$pdf->SetY(70);
		$pdf->SetX(5);
		$pdf->Cell(20,20,"*Conserve el ticket en buen estado*");
		//A set

		$code=$codigo_reserva;
		$pdf->Code128(2,90,$code,50,15);
		$pdf->SetY(80);
		$pdf->SetX(13);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(12,15,"reserva :".$codigo_reserva);
		//$pdf->Write(5,'A set: "'.$code.'"');
			//$pdf->Write(5,'A set: "'.$code.'"');
		//$pdf->Output();
		$pdf->Output('recibos/entrada/'.$codigo_reserva.'.pdf', 'F');
			//Header("Location: pages/index.php");

			//$nombre_archivo = 'recibos/entrada/'.$codigo_reserva.'.pdf';

		echo '<a href="recibos/entrada/' . $codigo_reserva . '.pdf" target="_blank">Descargar PDF</a>';
		//echo "asd";
		
		//header("Location: recibos/entrada/" . $codigo_reserva . ".pdf");
		//window.open("generaFactura.php?codigo_reserva=' . $codreserva . '", "_blank");
  			
	}
	
}if(isset($_GET['id_factura'])){

	$id_factura=$_GET['id_factura'];
	$valor=$bd->query("SELECT * FROM factura WHERE id_factura='$id_factura'");
	$valor=$bd->fetch();
	$cod_empleado=$valor['cod_empleado'];
	$codigo_reserva=$valor['cod_reserva'];
	$id_factura=$valor['id_factura'];
	$id_tipopago=$valor['id_tipopago'];
	$monto=$valor['monto'];
	$horario_salida=$valor['horario_salida'];

	$valor=$bd->query("SELECT * FROM reserva WHERE codigo_reserva='$codigo_reserva'");
	if($valor){
		$resultado=$bd->fetch();
		$patente=$resultado['patente'];
		$id_cochera=$resultado['id_cochera'];
		$hora_entrada=$resultado['hora_entrada'];

	$numero=$monto;
	$pdf=new PDF_Code128('P', 'mm', array(55, 120));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(28);
		$pdf->Cell(10,1,'GARAGE ');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(27);
		$pdf->Cell(40,5,' 24 HORAS');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,'---------------------------------------------');
		$pdf->Image('img/fotoAuto.png',2,4,20);
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(40,10,'TICKET DE SALIDA');
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(30,0,change($hora_entrada));
		$pdf->Ln();
		$pdf->SetX(7);
		$pdf->Cell(30,10,change($horario_salida));
		$pdf->SetX(7);
		//$pdf->Cell(40,10,$numero);
		$pdf->SetFont('Arial','B',20);
		$pdf->SetX(7);
		$pdf->Cell(40,35,$patente);
		$pdf->Ln();
		$pdf->SetX(10);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,0,"Cochera no.  ".$id_cochera);
		$pdf->SetFont('Arial','B',15);
		$pdf->SetX(11);
		$pdf->Cell(40,25,"Abona $".$monto);
		$pdf->SetX(2);
		$pdf->SetY(62);
		//$pdf->Cell(40,26,"*Conserve el ticket en buen estado*");
		//A set
		//$codigo = generarCodigoBarras(20);
		//$code='codigoBarra';  --->>> ESTO SI VA
		$pdf->Code128(2,90,$numero,50,15);
		$pdf->SetXY(0,45);
		//$pdf->Output();
		$pdf->Output('recibos/salida/'.$id_factura.'.pdf', 'F');
		//Header("Location: pages/index.php");

		header("Location: recibos/salida/" . $id_factura . ".pdf");
	}

}



?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>

            <!-- End of Main Content -->

            <!-- Footer -->

            <footer class="sticky-footer bg-white">

                 
            </footer>
             <?php require_once("footer.php")?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
