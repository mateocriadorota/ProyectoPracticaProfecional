 <!-- Nav Item - Pages Collapse Menu -->

 <?php // Verificar si la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    // Si no está iniciada, entonces la iniciamos
    session_start();
}
?>

<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Navegacion</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                       <!--  <h6 class="collapse-header">Cocheras:</h6>-->
                        <a class="collapse-item" href="historial.php">Historial</a>
                        <a class="collapse-item" href="facturacion.php">Facturacion</a>
                        <a class="collapse-item" href="cocheras.php">Cocheras</a>
                        <!--<a class="collapse-item" href="tarifa.php">Gestionar Tarifas</a>-->
                        <?php if(isset($_SESSION['isadmin']) ) { ?>
                          <div class="collapse-divider"></div>
                          <h6 class="collapse-header">Administrador:</h6>
                          
                          <a class="collapse-item" href="users.php">Administrar usuarios</a>
                          <a class="collapse-item" href="gestioncochera.php">Gestionar Cocheras</a>
                          <a class="collapse-item" href="tipoVehiculoMain2.php">Gestionar Vehiculos</a>
                          <a class="collapse-item" href="tarifa.php">Gestionar Tarifas</a>
                       <?php } ?>
                    </div>
                </div>  
</li>