<?php
session_start();
if(!isset($_SESSION['islogged'])) {
    header("Location: login.php");
    exit(1);
}
    include("../BD.php");
    $bd = new base();
    $bd->conectar();

    $bd2 = new base();
    $bd2->conectar();

    //llamamos al modulo que calcula la disponibilidad.
    include("../calculardisponibilidad.php");
    $diccionarioVehiculos = asignarDisponibilidad($vehiculos, $bd);
    
    //consultamos los datos para luego mostrarlos en la tabla
    $consultatabla = $bd->query("SELECT r.id_cochera, r.hora_entrada, v.patente, t.nombre
    FROM reserva r, tipo_vehiculo t, vehiculo v
    WHERE r.patente = v.patente
    AND v.id_tipovehiculo = t.id_tipovehiculo
    AND estado = 1
    ORDER BY r.hora_entrada DESC
    LIMIT 5;");
    $filas = $bd->fetchAll();



    //calculamos la cantidad de cocheras totales
    $consultatabla = $bd->query("SELECT * from cochera");
    $cantcocheras = $bd->fetchAll();
    $cantcocheras = count($cantcocheras);


    $consultaTiposVehiculo = $bd->query("SELECT * from tipo_vehiculo where activo=1");
    $consultaTiposVehiculo = $bd->fetchAll();
    ?>

   
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cocheras - Panel principal</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

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
                    <?php require_once("../topbar.php") ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-around mb-4">
                        <a href="salidavehiculo.php" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Salida de Vehiculos</a>
                         <a href="entradavehiculo.php" class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Entrada de Vehiculos</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total de cocheras:</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $cantcocheras ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                       <?php
                        foreach ($consultaTiposVehiculo as $vehiculo) {
                            ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Cocheras disponibles (<?php echo $vehiculo['nombre']; ?>):</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo isset($diccionarioVehiculos[$vehiculo['tamanio']]) ? count($diccionarioVehiculos[$vehiculo['tamanio']]) : 0; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        

    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <?php 
                        $cocheras = $bd->query("SELECT * from cochera where activo=1 ORDER BY ubicacion");
                        $cocheras=$bd->fetchAll();
                         ?>

                        <!-- Pie Chart -->
                        <div class="card shadow mb-4 h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cocheras:</h6>
                        </div>
                        <div class="card-body">  
                            <div class="text-center">
                                <div class="card-body">
                           

                                 <table class="table table-bordered" id="dataTable" >
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Tamanio</th>
                                        <th>Lugares</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($cocheras as $cochera) { ?>
                                        <tr>
                                             <td><?php echo $cochera['ubicacion']; ?></td>
                                            <td><?php echo $cochera['tamaniomax']; ?></td>
                                             <td>
                                                <div id="verde" style="color: green; font-weight: bold;"></div>
                                                <?php
                                                if (darEspacioLibre($cochera['id_cochera'], $bd2) == -1) {
                                                    echo '<div id="verde" style="color: green; font-weight: bold;">DISPONIBLE</div>';
                                                } else if (darEspacioLibre($cochera['id_cochera'], $bd2) == -2) {
                                                    echo '<div id="verde" style="color: red; font-weight: bold;"> OCUPADO</div>';
                                                } else {
                                                    echo '<div id="verde" style="color: orange; font-weight: bold;">' . darEspacioLibre($cochera['id_cochera'], $bd2) . '</div>';
                                                }
                                                ?>
                                            </td>
 
                                             
                                        </tr>
                                <?php } ?>
                                </tbody>
                                </table>
                                </div>
                            </div>

                        </div>
                    </div>

                        <div class="col-lg-6 mb-4">

<!-- Illustrations -->
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ultimos coches ingresados:</h6>
                </div>
                <div class="card-body">  
                    <div class="text-center">
                        <div class="card-body">
                   

                        <table class="table">
                        <thead>
                            <tr>
                                <th>Cochera</th>
                                <th>Patente</th>
                                <th>Tipo de Vehículo</th>
                                <th>Horario de Entrada</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($filas as $fila) { ?>
                                <tr>
                                     <td><?php echo $fila['id_cochera']; ?></td>  
                                     <td><?php echo $fila['patente']; ?></td>  
                                     <td><?php echo $fila['nombre']; ?></td>
                                     <td><?php echo $fila['hora_entrada']; ?></td>
                                </tr>
                        <?php } ?>
                        </tbody>
                        </table>
                        </div>
                    </div>

                </div>
            </div>
</div>
</div>

     </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

                  <!-- Footer -->
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
    <script src="../vendor/chart.js/Chart.min.js"></script>


</body>

<?php
// Obtener los valores de la base de datos
$enUso = 3;
$disponibles = 4;

?>

<!-- Incluir el código JavaScript generado por PHP -->
<script>
  var enUso = <?php echo $enUso; ?>;
  var disponibles = <?php echo $disponibles; ?>;

  // Pie Chart
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["En uso", "Disponibles"],
      datasets: [{
        data: [enUso, disponibles],
        backgroundColor: ['#1cc88a', '#dc3545'], // Cambiar colores aquí
        hoverBackgroundColor: ['#17a673', '#c82333'], // Cambiar colores aquí para el hover
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
</script>
</html>

