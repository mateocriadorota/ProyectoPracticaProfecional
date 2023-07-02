<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<script type="text/javascript">
    function mostrarHora() {
        var fecha = new Date();
        var hora = fecha.getHours();
        var minutos = fecha.getMinutes();
        var segundos = fecha.getSeconds();
        hora = (hora < 10 ? "0" : "") + hora;
        minutos = (minutos < 10 ? "0" : "") + minutos;
        segundos = (segundos < 10 ? "0" : "") + segundos;
        var tiempo = hora + ":" + minutos + ":" + segundos;
        document.getElementById("reloj").innerHTML = tiempo;
    }
    setInterval(mostrarHora, 1000);


</script>

<p>La hora actual es:</p>
<div id="reloj"></div>
<br>

<?php 
  include 'BD.php';

  $bd=new base();
  $bd->conectar();
  
  session_start();


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

}else if(isset($_GET['manual'])){

  $patente=$_GET['patente'];
  $dni=$_GET['dni'];
  $tipo_vehiculo=$_GET['tipo_vehiculo'];
  
  $arrayCocheras=espacioDisponible($tipo_vehiculo,$bd);

  if($arrayCocheras==false){
         echo '<script>alert("No hay lugares disponibles");</script>';
         echo '<script>window.location.href = "ingresoVehiculo.php";</script>';


           exit();
  }
  ?>
  <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="blank">
                <label>Patente</label>
                <input type="text" name="patente" value="<?= $patente?>" readonly ><br>
                
                <label >Dni</label>
                <input type="text" name="dni" value="<?= $dni?>" readonly>  
            
                <br>
                <?php
                //para setear el tipo de vehiculo eleguido...
                    $valorTipoVehiculo=$bd->query("SELECT nombre FROM tipo_vehiculo where id_tipovehiculo = '$tipo_vehiculo' ");
                    $valorTipoVehiculo = $bd->fetch();
                    
                ?>
                <label>Tipo de vehiculo:</label>
                <select name="tipo_vehiculo">
                    <option value="<?= $tipo_vehiculo ?>" ><?= $valorTipoVehiculo['nombre'] ?></option>
                </select>

                <br>
                <!-- select con cocheras disponibes  -->
                <label>cocheras disponibles </label>
                <select name="id_cochera">
                <?php
                    /*----------------Desplegable con las cocheras disponibles----------------*/
                    foreach ($arrayCocheras as $cochera) {
                        $ubicacion=$bd->query("SELECT ubicacion FROM cochera where id_cochera = '$cochera' ");
                        $ubicacion = $bd->fetch();
                        echo '<option value="' . $cochera . '"> ' . $ubicacion['ubicacion'] . '</option>';
                    }
                    echo '</select>';
                    /*-------------------------------------------------------------------------*/
                ?>

                <br>
                
                <input type="hidden" name="manual2">
                <input type="submit" value="confirmar" name="confirmar">
            </form>

            <form method="get" action="ingresoVehiculo.php">
                <input type="submit" value="volver">
            </form>


    <?php 



}else{

?>

  <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">


      <?php
       
       

      ?>
      <br>
      <label>Patente</label>
      <input type="text" name="patente"><br>
      
      <label >Dni</label>
      <input type="text" name="dni">  
    
  <!-- ****************************************** -->
      
      <br>
      <label>Tipo de vehiculo:</label>
      <select name="tipo_vehiculo">
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
    
    
    <br>
    <input type="submit" name="automatico" value="automatico"> 
    <input type="submit" name="manual" value="manual">
  </form>

<form method="get" action="main.php">
      <input type="submit" value="volver">
  </form>
</body>

</html>


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