<?php
//archivo que edita, elimina o agrega tarifas
if(session_status() != 2)
    session_start();

// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();

if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: index.php");
    exit(1);
}

$accion = $_GET['accion'];

//Guardando el id de la tarifa por la url
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    //Seleccionando cochera en la base de datos 
    $queryTarifa = "SELECT * FROM tarifa WHERE id_tarifa = '$id'";
    $respuestaTarifa = $base->query($queryTarifa);
    $filaTarifa = $base->fetch();
}

//Eliminando los datos de la tarifa en su tabla y en donde es clave foranea (tipo_vehiculo)
//NO ANDA - error en la foreign de tipo vehiculo
// if($accion == 'eliminar') {
//     $queryTipoVehiculo = "UPDATE tipo_vehiculo SET id_tarifa = NULL WHERE id_tarifa = $id";
// //    $queryTarifa = "DELETE FROM tarifa WHERE id_tarifa = $id";
    
//     $respuestaTipoVehiculo = $base->query($queryTipoVehiculo);
//     //$respuestaTarifa = $base->query($queryTarifa);
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion - Usuarios </title>

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


                <div class="container-fluid">

                <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="p-5">
                           <!-- **************** EDITAR TARIFA **************** -->
                            <?php if($accion == 'editar') { ?>
                                <div class="text-center">
                                    <!-- Cargando datos de la cochera actuales para editarlos si la accion es editar -->
                                    <h1 class="h4 text-gray-900 mb-4">EDITAR TARIFA</h1>
                                </div>
                                <form class="user" action="../changetarifa.php" method="POST">
                                    <!-- Oculto el id porque en la actualizacion lo necesito, para que no sea editado lo oculto -->
                                    <div class="form-group">
                                        <input type="hidden" class="form-control form-control-user" name="id" 
                                            value="<?php echo $filaTarifa['id_tarifa']?>" id="cochera_hidden">
                                    </div>
                                    <div class="form-group">
                                        <label for="ubicacion">Hora</label>
                                        <input type="text" class="form-control form-control-user" name="hora" value="<?php echo $filaTarifa['hora']?>" id="hora">
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">6 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="6horas" style="width: 100%;" value="<?php echo $filaTarifa['6horas']?>" id="6horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">12 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="12horas" style="width: 100%;" value="<?php echo $filaTarifa['12horas']?>" id="12horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">24 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="24horas" style="width: 100%;" value="<?php echo $filaTarifa['24horas']?>" id="24horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">Semana</label>
                                        <input type="text" class="form-control form-control-user" name="semana" style="width: 100%;" value="<?php echo $filaTarifa['semana']?>" id="semana" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">Mes</label>
                                        <input type="text" class="form-control form-control-user" name="mes" style="width: 100%;" value="<?php echo $filaTarifa['mes']?>" id="mes" />
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">
                                        CONFIRMAR
                                    </button>
                                </form>
                            <?php } ?>
                            <!-- **************** FIN EDITAR TARIFA **************** -->

                            <!-- **************** AGREGAR TARIFA **************** -->
                            <?php if($accion == 'agregar') { ?>
                                <div class="text-center">
                                    <!-- Cargando datos de la cochera actuales para editarlos si la accion es editar -->
                                    <h1 class="h4 text-gray-900 mb-4">EDITAR TARIFA</h1>
                                </div>
                                <form class="user" action="../changetarifa.php" method="POST">
                                    <!-- Oculto el id porque en la actualizacion lo necesito, para que no sea editado lo oculto -->
                                    <div class="form-group">
                                        <input type="hidden" class="form-control form-control-user" name="id" id="cochera_hidden">
                                    </div>
                                    <div class="form-group">
                                        <label for="ubicacion">Hora</label>
                                        <input type="text" class="form-control form-control-user" name="hora" id="hora">
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">6 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="6horas" style="width: 100%;" id="6horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">12 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="12horas" style="width: 100%;" id="12horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">24 Horas</label>
                                        <input type="text" class="form-control form-control-user" name="24horas" style="width: 100%;" id="24horas" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">Semana</label>
                                        <input type="text" class="form-control form-control-user" name="semana" style="width: 100%;" id="semana" />
                                    </div>
                                    <div class="form-group">
                                        <label for="tamanio">Mes</label>
                                        <input type="text" class="form-control form-control-user" name="mes" style="width: 100%;" id="mes" />
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">
                                        CONFIRMAR
                                    </button>
                                </form>
                            <?php } ?>
                            <!-- **************** FIN AGREGAR TARIFA **************** -->
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>

                    
            </div>
            
        </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
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