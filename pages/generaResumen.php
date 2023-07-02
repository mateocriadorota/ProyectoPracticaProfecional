<!DOCTYPE html>
<html>
<head>
	<title></title>
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Cocheras</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
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
            <?php require_once("../navmenu.php") ?>


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
                <?php require_once("../topbar.php"); ?>
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
                            <h6 class="m-0 font-weight-bold text-primary"></i>TICKET PARA CLIENTE </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                    <!-- Datos traidos de la consulta $fila -->
<?php

if(!isset($_SESSION['islogged']) ) {
    header("Location: pages/index.php");
    exit(1);
}



include '../BD.php';
$bd=new base();
$bd->conectar();


 $datosFacturacion = json_decode(urldecode($_GET['datosFacturacion']), true);



require('../libreria/fpdf/fpdf.php');
ob_start();

$pdf = new FPDF();
$pdf->AddPage();

// Logo
$pdf->Image('../img/fotoAuto.png', 10, 10, 40);

// Título
$pdf->SetFont('Arial', 'B', 28);
$pdf->SetX(88);
$pdf->Cell(10, 30, 'GARAGE');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(10, -60, 'RESUMEN PERIODO');
// Agregar espacio adicional
$pdf->Ln(10);

// Agregar línea divisoria horizontal
$pdf->SetLineWidth(0.4);


// Agregar imagen de auto


// Agregar espacio adicional
$pdf->Ln(-20);

// Agregar método de pago y valor
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Metodo de Pago', 0, 0, 'L');
$pdf->Cell(95, 10, 'Total', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);

// Agregar línea divisoria horizontal
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

// Agregar datos de facturación
foreach ($datosFacturacion as $clave => $valor) {
    $pdf->Cell(95, 10, $clave, 0, 0, 'L');
    $pdf->Cell(95, 10, ' $ ' . $valor, 0, 1, 'R');
}

// Agregar espacio adicional
$pdf->Ln(10);

// Generar el archivo PDF y descargarlo
$pdf->Output('archivo.pdf', 'F');
//$pdf->Output('recibos/entrada/'.$codigo_reserva.'.pdf', 'F');
			//Header("Location: pages/index.php");

			//$nombre_archivo = 'recibos/entrada/'.$codigo_reserva.'.pdf';

		echo '<a href="archivo.pdf" target="_blank">Descargar PDF</a>';



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
             <?php require_once("../footer.php")?>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

