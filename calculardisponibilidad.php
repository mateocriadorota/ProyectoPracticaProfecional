<?php 

function espacioDisponibleOrd($tipoVehiculo,$bd){
    $tamanioVehiculo=$bd->query(" SELECT tamanio from tipo_vehiculo where id_tipovehiculo = '$tipoVehiculo'");//consulto el tamanio para el tipo de vehiculo ingresado 
     $tamanioVehiculo = $bd->fetch();
     $tamanio =  $tamanioVehiculo['tamanio'];//cargo el tamanio
     /*------------hago consultas para traer las cocheras disponibles para el tipo de vehiculo en cuestion ------------*/
     //consulta de cocheras disponibles cuando no tienen ningun vechiculo asignado es decir estan vacias 

     $arrayCocheras = array();
     //$arrayCocheras[0]=null;
     $indice = 0;


     //consulta de cocheras disponibles cuando tienen algun vechiculo asignado
     $cocherasFULL=$bd->query(" SELECT reserva.id_cochera,cochera.tamaniomax-SUM(tamanio) as total 
                                 FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                 WHERE cochera.activo = 1 and reserva.estado=1 
                                 and cochera.id_cochera=reserva.id_cochera 
                                 and vehiculo.patente=reserva.patente 
                                 AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                 GROUP BY reserva.id_cochera HAVING total >= '$tamanio';");
    /* while($cocherasFULL=$bd->fetch()){
         $arrayCocheras[$indice] = $cocherasFULL['id_cochera'];//asigno el id de cochera al array con indice incrementable
         $indice ++;
     }*/

     $todas=$bd->fetchAll();

     $cocherasEmpty=$bd->query(" SELECT cochera.id_cochera,cochera.tamaniomax as total
                                 from cochera 
                                 where cochera.activo = 1 and cochera.id_cochera 
                                 not in(
                                         SELECT cochera.id_cochera 
                                         FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                         WHERE reserva.estado=1 and cochera.id_cochera=reserva.id_cochera 
                                         and vehiculo.patente=reserva.patente 
                                         AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                         GROUP BY reserva.id_cochera) 
                                         HAVING cochera.tamaniomax>='$tamanio';");
 
    //$arrayCocheras=0;
     $todas2=$bd->fetchAll();
     $todas3 = array_merge_recursive($todas2, $todas);
     //asort($todas3);
    // arsort($todas3);
    // ksort($todas3);
      //ksort($todas3);
      
    
    
   
// Ordenar el array multidimensional basado en la columna "edad"
    // Imprimir el array ordenado
    //print_r($todas3);
    //var_dump($todas3);

     foreach ($todas3 as $cochera ) {
          $arrayCocheras[$indice] = $cochera['id_cochera'];//asigno el id de cochera al array con indice incrementable
          $indice ++;
     }
     

     /*
     while($cocherasEmpty=$bd->fetch()){
         $arrayCocheras[$indice] = $cocherasEmpty['id_cochera'];//asigno el id de cochera al array con indice incrementable
         $indice ++;
     }
 */
     


     if(count($arrayCocheras) == 0){
       return false;//no hay lugar disponible para el vehiculo indicado.
     }else{
       return $arrayCocheras;
     }
     
}


function espacioDisponible($tipoVehiculo,$bd){
    $tamanioVehiculo=$bd->query(" SELECT tamanio from tipo_vehiculo where id_tipovehiculo = '$tipoVehiculo'");//consulto el tamanio para el tipo de vehiculo ingresado 
     $tamanioVehiculo = $bd->fetch();
     $tamanio =  $tamanioVehiculo['tamanio'];//cargo el tamanio
     /*------------hago consultas para traer las cocheras disponibles para el tipo de vehiculo en cuestion ------------*/
     //consulta de cocheras disponibles cuando no tienen ningun vechiculo asignado es decir estan vacias 

     $arrayCocheras = array();
     //$arrayCocheras[0]=null;
     $indice = 0;


     //consulta de cocheras disponibles cuando tienen algun vechiculo asignado
     $cocherasFULL=$bd->query(" SELECT reserva.id_cochera,cochera.tamaniomax-SUM(tamanio) as total 
                                 FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                 WHERE cochera.activo = 1 and reserva.estado=1 
                                 and cochera.id_cochera=reserva.id_cochera 
                                 and vehiculo.patente=reserva.patente 
                                 AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                 GROUP BY reserva.id_cochera HAVING total >= '$tamanio';");
    /* while($cocherasFULL=$bd->fetch()){
         $arrayCocheras[$indice] = $cocherasFULL['id_cochera'];//asigno el id de cochera al array con indice incrementable
         $indice ++;
     }*/

     $todas=$bd->fetchAll();

     $cocherasEmpty=$bd->query(" SELECT cochera.id_cochera,cochera.tamaniomax as total
                                 from cochera 
                                 where cochera.activo = 1 and cochera.id_cochera 
                                 not in(
                                         SELECT cochera.id_cochera 
                                         FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                         WHERE reserva.estado=1 and cochera.id_cochera=reserva.id_cochera 
                                         and vehiculo.patente=reserva.patente 
                                         AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                         GROUP BY reserva.id_cochera) 
                                         HAVING cochera.tamaniomax>='$tamanio';");
 
    //$arrayCocheras=0;
     $todas2=$bd->fetchAll();
     $todas3 = array_merge_recursive($todas2, $todas);
     //asort($todas3);
    // arsort($todas3);
    // ksort($todas3);
      //ksort($todas3);
      
     $edades = array_column($todas3, 'total');
    array_multisort($edades, SORT_ASC, $todas3);
    
   
// Ordenar el array multidimensional basado en la columna "edad"
    // Imprimir el array ordenado
    //print_r($todas3);
    //var_dump($todas3);

     foreach ($todas3 as $cochera ) {
          $arrayCocheras[$indice] = $cochera['id_cochera'];//asigno el id de cochera al array con indice incrementable
          $indice ++;
     }
     

     /*
     while($cocherasEmpty=$bd->fetch()){
         $arrayCocheras[$indice] = $cocherasEmpty['id_cochera'];//asigno el id de cochera al array con indice incrementable
         $indice ++;
     }
 */
     


     if(count($arrayCocheras) == 0){
       return false;//no hay lugar disponible para el vehiculo indicado.
     }else{
       return $arrayCocheras;
     }
     
}

$vehiculos = $bd->query("SELECT id_tipovehiculo from tipo_vehiculo");
$vehiculos = $bd->fetchAll();


function darEspacioLibre($id_cochera,$bd){

   $cochera=$bd->query("SELECT cochera.id_cochera,cochera.tamaniomax 
                                 from cochera 
                                 where cochera.activo = 1 and cochera.id_cochera='$id_cochera' and cochera.id_cochera 
                                 not in(
                                         SELECT cochera.id_cochera 
                                         FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                         WHERE reserva.estado=1 and cochera.id_cochera=reserva.id_cochera 
                                         and vehiculo.patente=reserva.patente 
                                         AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                         GROUP BY reserva.id_cochera) 
                                         HAVING cochera.tamaniomax>='0'");

   $cochera=$bd->fetch();
   if($bd->row()>0){
    return -2;
   }

   $cochera=$bd->query("SELECT reserva.id_cochera,cochera.tamaniomax-SUM(tamanio) as total 
                                 FROM reserva,cochera,vehiculo,tipo_vehiculo 
                                 WHERE cochera.activo = 1 and reserva.estado=1 
                                 and cochera.id_cochera=reserva.id_cochera and cochera.id_cochera='$id_cochera'
                                 and vehiculo.patente=reserva.patente 
                                 AND tipo_vehiculo.id_tipovehiculo=vehiculo.id_tipovehiculo 
                                 GROUP BY reserva.id_cochera HAVING total >  '0';");

   $cochera=$bd->fetch();
   if($bd->row()>0){
    return $cochera['total'];
   }

   return -1;



}



function asignarDisponibilidad($vehiculos, $bd) {
    $diccionario = array();
    
    // Recorremos los vehículos
    foreach ($vehiculos as $vehiculo) {
        $idVehiculo = $vehiculo['id_tipovehiculo'];
        // Asignamos la disponibilidad
        if((espacioDisponible($idVehiculo, $bd))!=false){
            $disponibilidad = espacioDisponible($idVehiculo, $bd);
            $diccionario[$idVehiculo] = $disponibilidad;
        }else{
            // $diccionario[$idVehiculo] = 0;
        }
        
        
        // Almacenamos la ID del vehículo y el array de cocheras disponibles en el diccionario
        
    }
    
    // Retornamos el diccionario con los vehículos y sus disponibilidades
    return $diccionario;
}

function cantidadVehiculo($vehiculos, $bd) {
    $vehiculo=0;
    
    $vehiculo=$bd->query("SELECT COUNT(*) as total FROM vehiculo, tipo_vehiculo, reserva WHERE vehiculo.patente = reserva.patente AND vehiculo.id_tipovehiculo = tipo_vehiculo.id_tipovehiculo AND tipo_vehiculo.id_tipovehiculo = '$vehiculos';");
    $vehiculo=$bd->fetch();
    return $vehiculo['total'];

 
        

        
}

?>