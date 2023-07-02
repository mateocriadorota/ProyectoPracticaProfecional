<?php //chequea que la sesion este iniciada
session_start();

if(!isset($_SESSION['islogged']) ) {
    header("Location: index.php");
    exit(1);
}
ob_start();

require('../libreria/fpdf/fpdf.php');
require_once("../BD.php");
// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$cod_empleado = $_SESSION["codigo_empleado"];
//se busca todas las ids de los tipos de pago
$arrayTipoPago=$base->query("SELECT * from tipo_pago");
 //se obtiene todos los id de estos en un array
$arrayTipoPago=$base->fetchAll();

function compararFechas($fecha1,$fecha2){
    

    $fecha1_sin_tiempo = date('Y-m-d', strtotime($fecha1));
    $fecha2_sin_tiempo = date('Y-m-d', strtotime($fecha2));

    if ($fecha1_sin_tiempo == $fecha2_sin_tiempo) {
        return true;
    } else {
        return false;
}

}

function verSaldos($base, $todos, $arrayTipoPago, $fecha_desde, $fecha_hasta, $cod_empleado){
    $sumaTotal=0;
    foreach ($arrayTipoPago as $tipoPago) {
        $id_tipopago = $tipoPago['id_tipopago'];
        $query = "SELECT COALESCE(SUM(monto), 0) as suma FROM factura WHERE id_tipopago='$id_tipopago' AND cod_empleado='$cod_empleado' AND horario_salida >= DATE_SUB(NOW(), INTERVAL 18 HOUR);";
        if($fecha_hasta && $fecha_desde){
            $query = "SELECT COALESCE(SUM(monto), 0) as suma FROM factura WHERE id_tipopago='$id_tipopago' AND DATE(horario_salida) >= DATE('$fecha_desde') AND DATE(horario_salida) <= DATE('$fecha_hasta');";
        }
        if($todos){
            $query = "SELECT COALESCE(SUM(monto), 0) as suma FROM factura WHERE id_tipopago='$id_tipopago' AND horario_salida >= DATE_SUB(NOW(), INTERVAL 18 HOUR);";
        }

        // Consulta para sumar el total de la plata facturada en ese tipo de pago durante las últimas 13 horas
        $total = $base->query($query);
        // Obtener la fila, donde 'suma' contiene el total
        $total = $base->fetch();
        // Guardamos los datos.
        $nombreTipoPago = ucfirst($tipoPago['nombre']);
        $sumaTotal = $sumaTotal+$total['suma'];
        $datosFacturacion[$nombreTipoPago] = $total['suma'];

    }
    $datosFacturacion['Total'] = $sumaTotal;

    return $datosFacturacion;
}

$datosFacturacionChart = verSaldos($base, false, $arrayTipoPago, null, null, $cod_empleado); 
if(isset($_SESSION['isadmin'])){
$datosFacturacionChart = verSaldos($base,true , $arrayTipoPago, null, null, $cod_empleado); 
}
unset($datosFacturacionChart['Total']);

                                                 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cocheras - Facturación diaria</title>

    <!-- Fuentes personalizadas para este template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Estilos personalizados para este template -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Contenedor de la página -->
    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Barra lateral - Marca -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-car"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Cocheras</div>
            </a>
            <!-- Separador -->
            <hr class="sidebar-divider my-0">

            <!-- Elemento de navegación - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>

            <!-- Separador -->
            <hr class="sidebar-divider">

            <!-- Título -->
            <div class="sidebar-heading">
                Navegación
            </div>

            <!-- Elemento de navegación - Menú desplegable de páginas -->
            <?php require_once "../navmenu.php"; ?>


            <!-- Separador -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Alternador de la barra lateral (Sidebar) -->
            

        </ul>
        <!-- Fin de la barra lateral -->

        <!-- Contenido de la página -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Contenido principal -->
            <div id="content">

                <!-- Barra superior -->
                <?php require_once "../topbar.php"; ?>
                <!-- Fin de la barra superior -->

                <!-- Inicio del contenido de la página -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow mb-4 ">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Facturación diaria por medio de pago:</h6>
                                </div>
                            <div class="card-body">
                                <?php if (array_sum($datosFacturacionChart) > 0): ?>
                                    <canvas id="myPieChart"></canvas>
                                <?php else: ?>
                                    <p>No hay datos disponibles para mostrar la estadística.</p>
                                <?php endif; ?>
                            </div>
                            </div>

                            <div class="card shadow mb-4">
                        <?php 
if(isset($_SESSION['isadmin'])){

                         ?>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detalle de facturación - Periodo</h6>
                        </div>
                    
                        <div class="card-body">
                            <form method="POST" action="facturacion.php">
                                <div class="form-group">
                                    <label for="fecha_desde">Desde:</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_hasta">Hasta:</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Generar Informe</button>
                            </form>
                                        <?php
                                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha_desde']) && isset($_POST['fecha_hasta']) && isset($_SESSION['isadmin'])) {
                                            $fechaHoraActual = date('Y-m-d');
                                            $timeDesde = date('Y-m-d',strtotime($_POST['fecha_desde']));
                                            $timeHasta = date('Y-m-d', strtotime($_POST['fecha_hasta']));
                                           // $timeActual=strtotime($fechaHoraActual);
                                           // echo($timeActual);


                                             if ($timeDesde <=  $fechaHoraActual && $timeHasta <=  $fechaHoraActual &&  $timeDesde <= $timeHasta) {
 

                                          /*  if(DATE($_POST['fecha_desde'])<=(($fechaHoraActual)) && DATE($_POST['fecha_hasta'])<=($fechaHoraActual)&& DATE($_POST['fecha_desde'])<=DATE($_POST['fecha_hasta'])){*/

                                                        $fecha_desde = $_POST['fecha_desde'];
                                                        $fecha_hasta = $_POST['fecha_hasta'];
                                                        
                                                        $datosFacturacion = verSaldos($base, false, $arrayTipoPago, $fecha_desde, $fecha_hasta, $cod_empleado);
                                                        foreach ($datosFacturacion as $nombreTipoPago => $sumaTotal) {
                                                                        echo $sumaTotal;

                                                                        
                                                        }
                                                         //   header('Location: ../generaResumen.php?datosFacturacion=' . urlencode(json_encode($datosFacturacion)));
                                                         
                                                      /*    echo '<script type="text/javascript">
                                                                window.open("../generaResumen.php?datosFacturacion=' . urlencode(json_encode($datosFacturacion)) . '", "_blank");
                                                                window.location.href = "../pages/facturacion.php";
                                                            </script>';*/
                                                            header('Location: generaResumen.php?datosFacturacion=' . urlencode(json_encode($datosFacturacion)) );



                                            }
                                            echo "Fechas invalidas";

                                        }

                                        ?>
                            </div>
                           
<?php 
} ?>
 </div>


                        </div>
                            <div class="col-md-6 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Detalle de facturación: (<?php echo ucfirst($_SESSION['usuario'])?>)</h6>
                                </div>
                                <div class="card-body h-100">
                                    <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo de Pago</th>
                                                        <th>Total Facturado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $datosFacturacion = verSaldos($base, false, $arrayTipoPago, null, null, $cod_empleado);
                                                    foreach ($datosFacturacion as $nombreTipoPago => $sumaTotal) {
                                                        echo "<tr>";
                                                        echo "<td>" . ucfirst($nombreTipoPago) . "</td>";
                                                        echo "<td>" . '$' . $sumaTotal . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                
                                                  
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
<?php 
if(isset($_SESSION['isadmin'])){

                         ?>
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Detalle de facturación: (todos) </h6>
                                </div>
                                <div class="card-body h-100">
                                    <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo de Pago</th>
                                                        <th>Total Facturado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $datosFacturacion = verSaldos($base, true, $arrayTipoPago, null, null, $cod_empleado);
                                                    foreach ($datosFacturacion as $nombreTipoPago => $sumaTotal) {
                                                        echo "<tr>";
                                                        echo "<td>" . ucfirst($nombreTipoPago) . "</td>";
                                                        echo "<td>" . '$' . $sumaTotal . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                
                                                  
                                                </tbody>
                                            </table>
                                    </div>
                                </div>

                           
                            <?php 
} ?>
                             </div>
                        </div>
                    </div>

                </div>
                <!-- Fin del contenido de la página -->

            </div>
            <!-- Fin del contenido principal -->

            <!-- Pie de página -->
            <?php require_once "../footer.php"; ?>
            <!-- Fin del pie de página -->

        </div>
        <!-- Fin del contenedor de la página -->

    </div>
    <!-- Fin del contenedor de la página -->

    <!-- Botón de desplazamiento hacia arriba -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin principal de JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Scripts personalizados para todas las páginas -->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Plugin Chart.js -->
    <script src="../vendor/chart.js/Chart.min.js"></script>
   
    <script>
    // Datos de facturación diaria por medio de pago desde el diccionario
                                    
    var datosFacturacion = <?php echo json_encode($datosFacturacionChart); ?>

    // Extraer las etiquetas y los valores del diccionario
    var labels = Object.keys(datosFacturacion);
    var valores = Object.values(datosFacturacion);

    // Construir el objeto de datos para el gráfico
    var data = {
        labels: labels,
        datasets: [{
            data: valores,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }],
    };

    // Opciones del gráfico de pastel
    var options = {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: 'bottom',
            labels: {
                usePointStyle: true,
                padding: 20,
            },
        },
        cutoutPercentage: 80,
    };

    // Obtener el contexto del gráfico de pastel
    var ctx = document.getElementById("myPieChart").getContext('2d');

    // Crear el gráfico de pastel con los datos actualizados
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
</script>


</body>

</html>

