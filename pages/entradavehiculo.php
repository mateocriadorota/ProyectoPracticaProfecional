<?php

include("../BD.php");
$bd = new base();
$bd->conectar();
session_start();

if(!isset($_SESSION['islogged'])) {
    header("Location: index.php");
    exit(1);
}
include("../calculardisponibilidad.php");
$diccionarioVehiculos = asignarDisponibilidad($vehiculos, $bd);
$diccionarioVehiculos2= asignarDisponibilidad($vehiculos, $bd);
foreach ($diccionarioVehiculos2 as &$subarray) {
  sort($subarray);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gestion - Usuarios</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                    <span>Home</span>
                </a>
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
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Ingreso de vehiculos.</h1>
                                        </div>
                                        <form class="user" action="confirmareserva.php" method="POST" >
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="patente" placeholder="Patente">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="exampleLastName" name="dni" placeholder="DNI (Opcional)">
                                            </div>
                                            <div class="form-group">
                                                <select class="form-select form-control-user col-sm p-3" id="exampleVehicleType" name="tipovehiculo">
                                                <option value="">Seleccionar vehículo</option>
                                                    <?php
                                                    $tiposVehiculos = $bd->query("SELECT id_tipovehiculo, nombre FROM tipo_vehiculo where activo=1");
                                                    $tiposVehiculos = $bd->fetchAll();
                                                    $bd2 = new base();
                                                    $bd2->conectar();
                                                    // Generar opciones del select utilizando los registros de la tabla tipo_vehiculos
                                                    
                                                        foreach ($tiposVehiculos as $tipoVehiculo) {
                                                            if(espacioDisponible($tipoVehiculo['id_tipovehiculo'],$bd2)!=false){
                                                                $id = $tipoVehiculo['id_tipovehiculo'];
                                                                $nombre = $tipoVehiculo['nombre'];
                                                                echo "<option value='$id'>$nombre</option>";
                                                        }
                                                }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="exampleCheck" value="" name="manual">
                                                    <label class="form-check-label" for="exampleCheck">
                                                        Asignar manualmente
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <div id="advancedOptions" style="display: none;">
                                                    <div class="form-group">
                                                        <select class="form-select form-control-user col-sm p-3" id="cocherasdisp" name="cochera" >

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">INGRESAR</button>
                                        </form>
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
    <script>
        document.getElementById("exampleCheck").addEventListener("change", function() {
            var advancedOptions = document.getElementById("advancedOptions");
            advancedOptions.style.display = this.checked ? "block" : "none";
        });
    </script>


<script>
    // Obtener el elemento checkbox
    var checkbox = document.getElementById("exampleCheck");
    // Obtener el elemento select de los espacios disponibles
    var selectEspacios = document.getElementById("cocherasdisp");
    // Obtener los espacios disponibles para todos los tipos de vehículos
   // var espaciosDisponibles = <?php echo json_encode($diccionarioVehiculos); ?>;
    // Verificar si el checkbox está marcado
    var checkboxChecked = checkbox.checked;

    // Función para cargar las opciones del select de espacios disponibles
    function cargarOpciones() {
    // Obtener el valor seleccionado en el primer select
    var tipoVehiculo = document.getElementById("exampleVehicleType").value;
    // Obtener los espacios disponibles para el tipo de vehículo seleccionado
   // var espaciosDisponibles2 = <?php echo json_encode($diccionarioVehiculos); ?>;
    var espaciosDisponibles = <?php echo json_encode($diccionarioVehiculos); ?>;
    var esp = espaciosDisponibles[tipoVehiculo][0];
    var espaciosDisponibles = <?php echo json_encode($diccionarioVehiculos2); ?>;
    var espacios = espaciosDisponibles[tipoVehiculo];

    

 
   
    if(!espacios) console.log("vacio");

    //deshabilitar check  y tambien tengo que desabilitar el boton de enviar y avisar al usuario que no hay cocheras disponibles

    else{
        selectEspacios.innerHTML = "";

        
    // Generar las opciones del select utilizando los espacios disponibles
        for (var i = 0; i < espacios.length; i++) {
            var idCochera = espacios[i];
            var opcion = document.createElement("option");
            opcion.value = idCochera;
            opcion.textContent = idCochera;
            selectEspacios.appendChild(opcion);

        }   
    }
  
    if (!checkbox.checked && espacios) {
        //selectEspacios.selectedIndex = 1;
        selectEspacios.value = esp;
    }

}

    // Evento para detectar los cambios en el checkbox
    checkbox.addEventListener("change", function() {
        var advancedOptions = document.getElementById("advancedOptions");
        advancedOptions.style.display = this.checked ? "block" : "none";
        if (this.checked) {
            cargarOpciones();
            document.getElementById("exampleVehicleType").disabled = false;
        } else {
            document.getElementById("exampleVehicleType").disabled = false;

        }
    });

    // Evento para detectar los cambios en el tipo de vehículo seleccionado
    document.getElementById("exampleVehicleType").addEventListener("change", cargarOpciones);
</script>

</body>

</html>
