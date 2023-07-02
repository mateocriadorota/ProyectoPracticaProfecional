<?php

// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();
session_start();
if(!isset($_SESSION['islogged']) ) {
    header("Location: index.php");
    exit(1);
}
//Consulta que trae las tarifas actuales con sus respectivos precios
$queryTarifa = "SELECT tf.id_tarifa, tf.hora, tf.6horas, tf.12horas, tf.24horas, tf.semana, tf.mes, tv.nombre FROM tarifa tf, tipo_vehiculo tv WHERE tv.id_tarifa = tf.id_tarifa and tv.activo=1";
$respuestaTarifa = $base->query($queryTarifa);
$filasTarifa = $base->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" con    tent="">
    <meta name="author" content="">

    <title>Gestion - Tarifas </title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

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

                   
                    <div class="d-flex justify-content-between p-4">
                        <h1 class="h3 mb-2 text-gray-800">Gestion de Tarifas</h1>
                        <!--
                        <a href="gestionartarifa.php?accion=agregar" class="btn btn-primary btn-icon-split" style="float: right;">
                         <span class="icon text-white-50">
                         <i class="uil uil-plus"></i>
                         </span>
                         <span class="text">Agregar Tarifa</span>
                     
                    NO SE PUEDEN AGREGAR TARIFAS
                      </a>-->
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
                    
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tarifas del sistema</h6>
                        </div>
                        <div class="card-body">
                            <!-- Contenedor de las tarifas - Clickeando en ella se obtiene la información -->
                            <div id="accordion">
                                <div class="card">
                                    <!-- Trayendo los datos y valores de las tarifas -->
                                    <?php foreach($filasTarifa as $index => $fila) { ?>
                                        <div class="card-header d-flex space" id="heading<?php echo $index ?>">
                                            <div class="mr-auto p-2">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link link-underline-opacity-0" data-toggle="collapse" data-target="#collapse<?php echo $index ?>" aria-expanded="false" aria-controls="collapse<?php echo $index ?>">
                                                        Tarifa de <?php echo ucfirst($fila['nombre'])?>
                                                    </button>
                                                </h5>
                                            </div>
                                            <div class="p-2">
                                                <!-- Se edita la tarifa sin pedir confirmacion -->
                                                <?php  
                                                if(isset($_SESSION['isadmin']) ) {
                                                    ?>
                                                 
                                                <a href="gestionartarifa.php?id=<?=$fila['id_tarifa']?>&accion=editar" class="btn btn-sm btn-primary editar" data-index="<?php echo $index ?>">
                                                    <i class="fas fa-edit"></i> <!-- Icono de editar -->
                                                </a>
                                                <?php 
                                                }
                                                ?>
                                                <!-- Se elimina la tarifa sin pedir confirmacion 
                                                <a href="gestionartarifa.php?id=<?=$fila['id_tarifa']?>&accion=eliminar" class="btn btn-sm btn-danger " data-index="<?php echo $index ?>">
                                                    <i class="fas fa-trash-alt"></i>  Icono de borrar -->
                                                </a>
                                            </div>
                                        
                                        </div>
                                        <div id="collapse<?php echo $index ?>" class="collapse" aria-labelledby="heading<?php echo $index ?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <!-- Trayendo los precios -->
                                                <p><span class="font-weight-bold">Precio Hora:</span> <?php echo $fila['hora']; ?>$</p>
                                                <p><span class="font-weight-bold">Precio Media Estadia(6HS):</span> <?php echo $fila['6horas']; ?>$</p>
                                                <p><span class="font-weight-bold">Precio Estadia(12HS):</span> <?php echo $fila['12horas']; ?>$</p>
                                                <p><span class="font-weight-bold">Precio por Día(24HS):</span> <?php echo $fila['24horas']; ?>$</p>
                                                <p><span class="font-weight-bold">Precio por Semana:</span> <?php echo $fila['semana']; ?>$</p>
                                                <p><span class="font-weight-bold">Precio por Mes:</span> <?php echo $fila['mes']; ?>$</p>
                                            </div>
                                        </div>
                                    <?php } ?>
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
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>