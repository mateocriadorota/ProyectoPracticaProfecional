<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>





<?php 
  include 'BD.php';

  $bd=new base();
  $bd->conectar();
  
  session_start();

if(!isset($_SESSION['islogged']) ) {
    header("Location: pages/index.php");
    exit(1);
}
if(isset($_GET['manual2'])){
    $id_cochera=$_GET['id_cochera'];
    $patente=$_GET['patente'];
    $dni=$_GET['dni'];
    $tipo_vehiculo=$_GET['tipo_vehiculo'];

    echo '<script type="text/javascript"> 
           
           window.open("cargaReserva.php?patente=' . $patente . '&dni=' . $dni . '&tipo_vehiculo=' . $tipo_vehiculo . '&id_cochera=' . $id_cochera . '", "_blank");
           window.location.href = "main.php";
      </script>';


    exit();
  }

if(isset($_GET['automatico'])){

  $patente=$_GET['patente'];
  $dni=$_GET['dni'];
  $tipo_vehiculo=$_GET['tipo_vehiculo'];
  $arrayCocheras=espacioDisponible($tipo_vehiculo,$bd);
  if($arrayCocheras==true){
    $id_cochera=$arrayCocheras[0];

          echo '<script type="text/javascript"> 
           
           window.open("cargaReserva.php?patente=' . $patente . '&dni=' . $dni . '&tipo_vehiculo=' . $tipo_vehiculo . '&id_cochera=' . $id_cochera . '", "_blank");
           window.location.href = "main.php";
      </script>';

   exit();
  }else{

      echo '<script>alert("No hay lugares disponibles");</script>';
      echo '<script>window.location.href = "ingresoVehiculo.php";</script>';

  }

}else {
?>

  <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <br>
      <label>Patente</label>
      <input type="text" name="patente"><br>
      
      <label >Dni</label>
      <input type="text" name="dni">  
    
  <!-- ****************************************** -->
      
      <br>
      <label>Tipo de vehiculo:</label>
      <select name="tipo_vehiculo" id="desplegable1" onchange="actualizarDesplegable2()">
        <option value="" disabled selected>Seleccionar opción</option>
      <?php
        /*----------imprimo en un select todos los tipos de vehiculo----------*/
        $resultado=$bd->query("SELECT * FROM tipo_vehiculo");

          while($valorTipoVehiculo=$bd->fetch()) {
            
            $bd2=new base();
            $bd2->conectar();
            if(espacioDisponible($valorTipoVehiculo['id_tipovehiculo'],$bd2)!=false){

                echo '<option value="' . $valorTipoVehiculo['id_tipovehiculo'] . '"> ' . $valorTipoVehiculo['nombre']  . '</option>';
            }
          }
        echo '</select>';
        /*----------------------------------------------------------------------*/
      ?>
      <input type="checkbox" id="checkbox" onchange="mostrarDesplegable()">
      <label for="checkbox">Mostrar desplegable</label>

     <label>cocheras disponibles </label>
                <select name="id_cochera" id="desplegable2" style="display: none;" >

                <?php

                    echo '</select>';
                   
                ?>

    <br>
    <input type="submit" name="automatico" value="automatico"> 
    <input type="submit" name="manual2" value="manual">
  </form>
<form method="get" action="main.php">
      <input type="submit" value="volver">
  </form>
</body>
</html>


<script type="text/javascript">
  function mostrarDesplegable() {
  var checkbox = document.getElementById("checkbox");
  var desplegable = document.getElementById("desplegable2");

  // Mostrar u ocultar el desplegable según el estado del checkbox
  if (checkbox.checked) {
    desplegable.style.display = "block";
  } else {
    desplegable.style.display = "none";
  }
}

</script>
<?php 
}









function espacioDisponible($tipoVehiculo,$bd){

   $tamanioVehiculo=$bd->query(" SELECT tamanio from tipo_vehiculo where id_tipovehiculo = '$tipoVehiculo'");//consulto el tamanio para el tipo de vehiculo ingresado 
    $tamanioVehiculo = $bd->fetch();
    $tamanio =  $tamanioVehiculo['tamanio'];//cargo el tamanio
    /*------------hago consultas para traer las cocheras disponibles para el tipo de vehiculo en cuestion ------------*/
    //consulta de cocheras disponibles cuando no tienen ningun vechiculo asignado es decir estan vacias 
    $cocherasEmpty=$bd->query(" SELECT cochera.id_cochera,cochera.tamaniomax 
                                from cochera 
                                where cochera.id_cochera 
                                not in(
                                        SELECT cochera.id_cochera 
                                        FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                        WHERE reserva.estado=1 and cochera.id_cochera=reserva.id_cochera 
                                        and vehiculo.patente=reserva.patente 
                                        AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                        GROUP BY reserva.id_cochera) 
                                        HAVING cochera.tamaniomax>='$tamanio';");


    $arrayCocheras = array();
    $arrayCocheras[0]=null;
    $indice = 0;
    while($cocherasEmpty=$bd->fetch()){
        $arrayCocheras[$indice] = $cocherasEmpty['id_cochera'];//asigno el id de cochera al array con indice incrementable
        $indice ++;
    }

    //consulta de cocheras disponibles cuando tienen algun vechiculo asignado
    $cocherasFULL=$bd->query(" SELECT reserva.id_cochera,cochera.tamaniomax-SUM(tamanio) as total 
                                FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                WHERE reserva.estado=1 
                                and cochera.id_cochera=reserva.id_cochera 
                                and vehiculo.patente=reserva.patente 
                                AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                GROUP BY reserva.id_cochera HAVING total >= '$tamanio';");


    while($cocherasFULL=$bd->fetch()){
        $arrayCocheras[$indice] = $cocherasFULL['id_cochera'];//asigno el id de cochera al array con indice incrementable
        $indice ++;
    }

   

    if(isset($arrayCocheras[0])==null){
        
      return false;//no hay lugar disponible para el vehiculo indicado.
    }else{
      return $arrayCocheras;
    }
}

?>

<script type="text/javascript">
  function actualizarDesplegable2() {
    var desplegable1 = document.getElementById("desplegable1");
    var desplegable2 = document.getElementById("desplegable2");
    
    // Eliminar todas las opciones actuales del desplegable2
    desplegable2.innerHTML = "";
    
    // Obtener el valor seleccionado del desplegable1
    var opcionSeleccionada = desplegable1.value;
    
    // Generar nuevas opciones para el desplegable2 según la selección del desplegable1

    <?php 
        $bd4 = new base();
        $bd4->conectar();
        $valorTipoVehiculo=$bd4->query("SELECT id_tipovehiculo FROM tipo_vehiculo  ");
         while ($valorTipoVehiculo4 = $bd4->fetch()) { 
                $bd = new base();
                    $bd->conectar();
                    $tipo_vehiculo=$valorTipoVehiculo4['id_tipovehiculo'];
                $valorTipoVehiculo=$bd->query("SELECT * FROM tipo_vehiculo where id_tipovehiculo = '$tipo_vehiculo' ");
                 //$valorTipoVehiculo = $bd->fetch();

                while ($valorTipoVehiculo = $bd->fetch()) { 
                    $bd2 = new base();
                    $bd2->conectar();
                    if (espacioDisponible($valorTipoVehiculo['id_tipovehiculo'], $bd2) != false) {
                ?>
                  if (opcionSeleccionada == '<?php echo $valorTipoVehiculo['id_tipovehiculo']; ?>') {
                    //  var opciones = ["Opción 1-1", "Opción 1-2", "Opción 1-3"];
                
                    var opciones = <?php echo json_encode(espacioDisponible($valorTipoVehiculo['id_tipovehiculo'], $bd2)); ?>;
                  }
               //  
                <?php } } ?>
                //var opciones = ["Opción 1-1", "Opción 1-2", "Opción 1-3"];
                <?php } ?>
                // Agregar las nuevas opciones al desplegable2
                for (var i = 0; i < opciones.length; i++) {
                  var opcion = document.createElement("option");
                  opcion.text = opciones[i];
                  opcion.value = opciones[i];
                  desplegable2.add(opcion);

    }
    
  }
</script>

         