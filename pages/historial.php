<?php
//chequea que la sesion este iniciada
session_start();
if(!isset($_SESSION['islogged'])) {
    header("Location: login.php");
    exit(1);
}

// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();
$resultados = $base->query("SELECT * from tipo_pago");
$tiposPago = $base->fetchAll();
// Realiza la consulta a la tabla "reserva" y obtiene los resultados
$query = "SELECT fa.id_tipopago ,fa.id_factura,fa.monto, fa.horario_salida, r.id_cochera, r.codigo_reserva, r.patente, e.nombre, e.apellido, r.hora_entrada,fa.cod_empleado from  factura fa, reserva r, empleado e WHERE r.estado = 0 AND r.cod_empleado = e.cod_empleado AND fa.cod_reserva = r.codigo_reserva";
$resultados = $base->query($query);
$filas = $base->fetchAll();

$tiposVehiculo = $base->query("SELECT * FROM vehiculo,tipo_vehiculo where vehiculo.id_tipovehiculo=tipo_vehiculo.id_tipovehiculo  and tipo_vehiculo.activo=1");
$tiposVehiculo=$base->fetchAll();
function change($date){
    $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $fechaCambiada =$fecha->format('d/m/Y H:i:s');
    return $fechaCambiada;

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
                        <h1 class="h3 mb-2 text-gray-800">Historial <i class="uil uil-history"></i></h1>
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
                            <h6 class="m-0 font-weight-bold text-primary"></i>Historial del reservas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <!-- numeroCochera - tipovehiculo - patente - hora entrada y salida - monto pago - empleado - empleado cobro -->
                                        <tr>
                                            <th>Codigo Reserva</th>
                                            <th>Cochera</th>
                                            <th>Reservado por</th>
                                            <th>Cobrado por</th>
                                           <!-- <th>Codigo reserva</th>-->
                                            <th>Patente</th>
                                            <th>Vehiculo</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <?php if(isset($_SESSION['isadmin']))
                                            if($_SESSION['isadmin']) { ?>
                                            <th>Monto</th>
                                              <?php } ?>
                                             <th>Tipo Pago</th>
                                          
                                            <th>Re Imprimir</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($filas as $fila) { ?>
    <tr>
        <?php 
        $empleadoCobra = $fila['cod_empleado'];
        $empleado = $base->query("SELECT * from empleado WHERE cod_empleado='$empleadoCobra'");
        $empleado = $base->fetch();
        ?>

        <td><?php echo $fila['codigo_reserva']; ?></td>
        <td><?php echo $fila['id_cochera']; ?></td>
        <td><?php echo ucfirst($empleado['nombre']) . ' ' . ucfirst($empleado['apellido']); ?></td>
        <td><?php echo ucfirst($fila['nombre']) . ' ' . ucfirst($fila['apellido']); ?></td>
        <td><?php echo $fila['patente']; ?></td>
        <td><?php
            foreach ($tiposVehiculo as $tipo) {
                if($tipo['patente']==$fila['patente']){
                    echo $tipo['nombre'];
                }
            }
         
          ?></td>
        <td><?php echo change($fila['hora_entrada']); ?></td>
        <td><?php echo change($fila['horario_salida']); ?></td>

        <?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']) { ?>
            <td><?php echo '$' . $fila['monto']; ?></td>
            
<?php } ?>

            <th><?php 
                foreach ($tiposPago as $tipo) {
                    if ($tipo['id_tipopago'] == $fila['id_tipopago']) {
                        echo ucfirst($tipo['nombre']);
                    }
                }
            ?></th>
            <td>
                <a href="generaFactura2.php?id_factura=<?php echo $fila['id_factura']; ?>" class="btn btn-sm btn-primary" target="_blank">Imprimir Ticket</a>
            </td>
            </tr>
<?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
 <?php require_once("../footer.php")?>
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

</body>

</html>