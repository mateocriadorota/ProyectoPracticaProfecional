<?php
session_start();
if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: index.php");
    exit(1);
}

// Incluye el archivo que contiene la clase "base"
require_once("../BD.php");

// Crea una instancia de la clase "base"
$base = new base();
$base->conectar();


// Realiza la consulta a la tabla "empleados" y obtén los resultados
$query = "SELECT username, cod_empleado, nombre, apellido, id_rol FROM empleado where activo=1";
$resultados = $base->query($query);
$filas = $base->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" con    tent="">
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
                    <h1 class="h3 mb-2 text-gray-800">Gestion de usuarios</h1>
                      <a href="agregarusuario.php" class="btn btn-primary btn-icon-split" style="float: right;">
                         <span class="icon text-white-50">
                          <i class="fas fa-user-plus"></i>
                         </span>
                             <span class="text">Agregar usuario</span>
                      </a>
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
                            <h6 class="m-0 font-weight-bold text-primary">Usuarios del sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($filas as $fila) { ?>
                                      <tr>
                                      <td><?php echo $fila['username']; ?></td>
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <td><?php echo $fila['apellido']; ?></td>
                                        
                                        <td>
                                                                               
                                        <a href="actualizarusuario.php?id=<?=$fila['cod_empleado']?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> <!-- Icono de editar -->
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger deleteUserLink" data-userid="<?=$fila['cod_empleado']?>">
                                            <i class="fas fa-trash-alt"></i> <!-- Icono de borrar -->
                                        </a>
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


    <div class="modal" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a href="#" id="deleteUserButton" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.deleteUserLink').click(function(e) {
            e.preventDefault(); // Evita el comportamiento predeterminado del enlace

            var userId = $(this).data('userid'); // Obtiene el ID del usuario a eliminar
            var deleteUrl = '../eliminarusuario.php?id=' + userId; // URL para eliminar el usuario

            // Actualiza el enlace de eliminación en el modal con la URL correcta
            $('#deleteUserButton').attr('href', deleteUrl);

            // Abre el modal de confirmación
            $('#confirmDeleteModal').modal('show');
        });
    });
</script>

</body>



</html>