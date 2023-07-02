<?php   

session_start();

if(!isset($_SESSION['islogged']) || !$_SESSION['isadmin']) {
    header("Location: pages/index.php");
    exit(1);
}

include 'BD.php';
$bd=new base();
$bd->conectar();

if(isset($_POST['ubicacion']) && isset($_POST['tamanio'])){
    $ubicacion=$_POST['ubicacion'];
    $tamanio=$_POST['tamanio'];

    // Validar que los campos requeridos no estén vacíos
    if(empty($ubicacion) || empty($tamanio)) {
        $_SESSION['error_message'] = "Debes completar todos los campos.";
        header("Location: pages/gestioncochera.php");
        exit;
    }
    $valor=$bd->query("SELECT * FROM cochera WHERE id_cochera='$ubicacion' and activo=1");
    
    if($bd->row()>0){
        $valor=3;
    }else{
        $valor=$bd->query("SELECT * FROM cochera WHERE id_cochera='$ubicacion' and activo=0");
        if($bd->row()>0){
             $valor=$bd->query("UPDATE `cochera` SET `id_cochera`='$ubicacion',`tamaniomax`='$tamanio',`ubicacion`='999',`techado`='1',`activo`='1' WHERE id_cochera='$ubicacion' and activo=0");

        }else {

            $bd->query("SELECT * FROM cochera WHERE id_cochera='$ubicacion' ");
            if($bd->row()==0){
                $valor=$bd->query("INSERT INTO cochera (id_cochera,tamaniomax, ubicacion, activo) VALUES ('$ubicacion','$tamanio',9999,1)");
            }
        }


    }

  
       

    if($valor == 1){
        $_SESSION['success_message'] = 'Cochera creada.';
        header("Location: pages/gestioncochera.php");    
    }else if(!$valor){
        $_SESSION['error_message'] = 'Ha ocurrido un error, vuelve a intentarlo mas tarde' .  $valor;
        header("Location: pages/gestioncochera.php");       
    }else{
        $_SESSION['error_message'] = 'Esa cochera ya existe';
        header("Location: pages/gestioncochera.php");  
    }
}