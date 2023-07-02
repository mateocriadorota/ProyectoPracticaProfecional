<?php
// Incluye el archivo que contiene la clase "base"
session_start();
if(!isset($_SESSION['islogged']) ) {
    header("Location: index.php");
    exit(1);
}
require_once("../BD.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

function change($date){
    $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $fechaCambiada =$fecha->format('d/m/Y H:i:s');
    return $fechaCambiada;

}
//Obtiene el ID por medio de la url para hacer la query de la reserva y se le asigna en una variable
//$id = $_GET['id'];

// Realiza la consulta a la tabla "reserva" y obtiene los resultados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patente = $_POST["patente"];
    $dni = isset($_POST["dni"]) ? $_POST["dni"] : null;
    $tipovehiculo = $_POST["tipovehiculo"];
    $cochera = $_POST["cochera"];
    $idempleado = $_SESSION["codigo_empleado"];
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $horaEntrada= date('Y-m-d H:i:s');
    if (empty($patente) || empty($tipovehiculo) || empty($cochera)) {
            $_SESSION['error_message'] = "Debes completar todos los campos.";
            header("Location: entradavehiculo.php");
            exit();
    }
      $query = "SELECT nombre from tipo_vehiculo where id_tipovehiculo='$tipovehiculo'";
    $resultados = $base->query($query);
    $vehiculo = $base->fetch();

}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" con    tent="">
    <meta name="author" content="">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <title>Confirmar Reserva</title>

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
                    <i class="fas fa-laugh-wink"></i>
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
                        <h1 class="h3 mb-2 text-gray-800">Datos de la Reserva</h1>
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
                            <h6 class="m-0 font-weight-bold text-primary">Finalizar Reserva</h6>
                        </div>
                        <div class="card-body shadow ">
                            <div>
                                <p class="d-block lead"><span class="font-weight-bold">Patente:</span> <?php echo $patente ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Dni:</span> <?php echo $dni; ?></p>
                                   <p class="d-block lead"><span class="font-weight-bold">Tipo de Vehículo:</span> <?php echo $vehiculo['nombre']; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Hora de Entrada:</span> <?php echo change($horaEntrada); ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Cochera:</span> <?php echo $cochera; ?></p>

                               
                            </div>
                                <form action="../cargareserva.php" method="POST"  >
                                    
                                    <input type="hidden" value="<?php echo $patente ?>" name="patente">
                                        <input type="hidden" value="<?php echo $dni; ?>" name="dni">
                                        <input type="hidden" value="<?php echo $tipovehiculo; ?>" name="tipovehiculo">
                                        <input type="hidden" value="<?php echo $horaEntrada; ?>" name="hsentrada">
                                        <input type="hidden" value="<?php echo $cochera; ?>" name="cochera">    
                                   

                                    <input type="submit" class="d-block mt-3 btn btn-success" >
                                </form>
                            </div>
                        </div>
                    </div>

                                        <!-- Footer -->
          
            <!-- End of Footer -->
                </div>
                <!-- /.container-fluid -->
<?php require_once("../footer.php")?>
                </div>
                  
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
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
    <!-- NO ES NECESARIO USARLO PARA CONFIRMAR LA RESERVA -->
    <!-- <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>



