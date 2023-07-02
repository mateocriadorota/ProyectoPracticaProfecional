<?php
// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');


session_start();
if(!isset($_SESSION['islogged']) ) {
    header("Location: index.php");
    exit(1);
}
// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

//Obtiene el ID por medio de la url para hacer la query de la reserva y se le asigna en una variable
$id = $_GET['id'];

// Realiza la consulta a la tabla "reserva" y obtiene los resultados
$query = "SELECT reserva.codigo_reserva,reserva.id_cochera,tipo_vehiculo.nombre,reserva.patente,reserva.hora_entrada,reserva.cod_empleado  FROM reserva,tipo_vehiculo,vehiculo WHERE reserva.patente = vehiculo.patente AND tipo_vehiculo.id_tipovehiculo = vehiculo.id_tipovehiculo AND reserva.codigo_reserva = $id";
$resultados = $base->query($query);
$fila = $base->fetch();

//trayendo de la base los tipo de pago
$queryTipoPago = "SELECT * FROM tipo_pago";
$resultadosTipoPago = $base->query($queryTipoPago);
$filasTipoPago = $base->fetchAll();

$fechaHoraSalida = date('Y-m-d H:i:s');



$monto=calculaMonto($fila['hora_entrada'],$fechaHoraSalida,$base,$fila['codigo_reserva']);

$segundosTotales = segundosTotales($fila['hora_entrada'], $fechaHoraSalida);
$dias = floor($segundosTotales / 86400);
$horas = floor(($segundosTotales % 86400) / 3600);
$minutos = floor(($segundosTotales % 3600) / 60);
$segundos = $segundosTotales % 60;
/*
$fecha1 = DateTime::createFromFormat('Y-m-d H:i:s', $fila['hora_entrada']);

$horaEntrada =$fecha1->format('d/m/Y H:i:s');*/
   // $tiempoTotal = DateTime::createFromFormat('H:i:s', sprintf(' %02d:%02d:%02d', $horas, $minutos, $segundos));  

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

    <title>Finalizar Reserva</title>

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
                                <p class="d-block lead"><span class="font-weight-bold">Código Reserva:</span> <?php echo $fila['codigo_reserva']; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Cochera:</span> <?php echo $fila['id_cochera']; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Patente:</span> <?php echo $fila['patente']; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Tipo de Vehículo:</span> <?php echo ucfirst($fila['nombre']); ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Hora de Entrada:</span> <?php echo change($fila['hora_entrada']);; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Hora de Salida:</span> <?php echo change($fechaHoraSalida);; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Tiempo de estadia:</span> <?php echo $dias 
                                ." Dias ". $horas." Horas ". $minutos." Minutos ". $segundos." Segundos"; ?></p>
                                <p class="d-block lead"><span class="font-weight-bold">Monto a Pagar:</span> <?php echo "$ ".$monto?></p>
                            </div>
                                <form action="../finalizarreserva.php" method="POST"  >
                                    <label class="lead mt-3">Tipo de Pago</label> 
                                    <input type="hidden" value="<?php echo $fila['patente'] ?>" name="patente">
                                        <input type="hidden" value="<?php echo $fila['id_cochera']?>" name="idcochera">
                                        <input type="hidden" value="<?php echo $fila['codigo_reserva']?>" name="codigo_reserva">
                                        <input type="hidden" value="<?php echo $fila['hora_entrada']?>" name="hsentrada">
                                        <input type="hidden" value="<?php echo $fechaHoraSalida ?>" name="hsalida">    
                                        <input type="hidden" value="<?php echo $monto ?>" name="monto">  

                                    <select name="metodopago" class="form-select form-control-user rounded p-1">
                                        <?php foreach ($filasTipoPago as $filaPago) { ?>  
                                            <option value= "<?php echo $filaPago['id_tipopago']?>" ><?= ucfirst($filaPago['nombre']);?></option>
                                        <?php } ?>
                                    </select>

                                    <input type="submit" class="d-block mt-3 btn btn-success" >
                                </form>
                            </div>
                        </div>
                    </div>

                                        <!-- Footer -->
            <?php require_once("../footer.php")?>
            <!-- End of Footer -->
                </div>
                <!-- /.container-fluid -->
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




<?php 


function calculaMonto($horaEntrada,$horaSalida,$bd,$codigo_reserva){

    $valor=$bd->query("SELECT tipo_vehiculo.id_tipovehiculo from tipo_vehiculo,vehiculo,reserva where tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo and vehiculo.patente=reserva.patente and reserva.codigo_reserva='$codigo_reserva' ");//esto va en 0
    $valor=$bd->fetch();
    $id_tipovehiculo=$valor['id_tipovehiculo'];
    $valor=$bd->query("SELECT * from tipo_vehiculo,tarifa where id_tipovehiculo='$id_tipovehiculo' and tipo_vehiculo.id_tarifa=tarifa.id_tarifa");
    /*$valor=$bd->query("SELECT tarifa.id_tarifa from tarifa,tipo_vehiculo where tarifa.id_tarifa=tipo_vehiculo.id_tipovehiculo and tipo_vehiculo.id_tipovehiculo='$id_tipovehiculo'");*/
    $arrayTarifa=$bd->fetch();
    //$id_tarifa=$arrayTarifa['id_tarifa'];
    $fecha1 = DateTime::createFromFormat('Y-m-d H:i:s', $horaEntrada);
    $fecha2 = DateTime::createFromFormat('Y-m-d H:i:s', $horaSalida);
    $timestamp1=$fecha1->getTimestamp();
    $timestamp2=$fecha2->getTimestamp();

    $diferencia_en_segundos = $timestamp2  - $timestamp1;
    $minTotal = round($diferencia_en_segundos / 60);

    if ($minTotal < 360) {
        $cobro = 'hora';
    } elseif ($minTotal < 720) {
        $cobro = '6horas';
    }  elseif ($minTotal < 1440) {
        $cobro = '12horas';
    } elseif ($minTotal < 10080) {
        $cobro = '24horas';
    } elseif ($minTotal < 43200) {
        $cobro = 'semana';
    } else {
        $cobro = 'mes';
    }

    $setFraccion=5;
    $precioHora=$arrayTarifa[$cobro];

    if ($cobro == 'hora'&& $arrayTarifa['hora']!=0) {
        $valorFraccion=$precioHora/(60/$setFraccion);
    }if ($cobro == '6horas'&& $arrayTarifa['6horas']!=0) {
        $valorFraccion=$precioHora/(60/$setFraccion);
    }if ($cobro == '12horas'&& $arrayTarifa['12horas']!=0) {
        $valorFraccion=$precioHora/(60/$setFraccion);
    }if ($cobro == '24horas'&& $arrayTarifa['24horas']!=0) {
        $valorFraccion=$precioHora/(60/$setFraccion);
    }if ($cobro == 'semana'&& $arrayTarifa['semana']!=0) {
        $valorFraccion=$precioHora/(60/$setFraccion);
    }else{
        $valorFraccion=$precioHora/(60/$setFraccion);
    }

    $fracciones = round($minTotal / $setFraccion);
    if (($minTotal % $setFraccion) <=$setFraccion) {
        $montoTotal = $valorFraccion * ceil($minTotal / $setFraccion);
        if($montoTotal==0){
            $montoTotal=$valorFraccion;
        }
        return  round($montoTotal);
    } else {
        $fracciones++;
        return  round($valorFraccion * $fracciones);
    }   
    
}

function segundosTotales($horaEntrada,$horaSalida){

    $fecha1 = DateTime::createFromFormat('Y-m-d H:i:s', $horaEntrada);
    $fecha2 = DateTime::createFromFormat('Y-m-d H:i:s', $horaSalida);
    $timestamp1=$fecha1->getTimestamp();
    $timestamp2=$fecha2->getTimestamp();
    $diferencia_en_segundos = $timestamp2  - $timestamp1;
    $segTotal = round($diferencia_en_segundos );

    return $segTotal;

}


 ?>