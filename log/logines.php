<?php 
session_start();

if(isset($_SESSION['login'])){
    header('Location: main/consulta.php');
    exit();
}

if (isset($_POST['consulta']))
{  
    include 'cnxlo.php'; 
    
    $codigoe = $conex->real_escape_string($_POST['codigoePHP']);  

    $data = $conex->query("SELECT codigoe FROM estudiante WHERE codigoe = '".$codigoe."'");    
    if ($data->num_rows > 0){
        $_SESSION['login'] = true;
        $_SESSION['estudiante'] = $codigoe;
        header("Refresh:1; url=consulta.php");
        exit('<script> window.location = "main/consulta.php"; </script>');        
    }     
    else {
        exit('<script> swal({title: "Uppss...!",text: "Tú codigo no se encunentra registrado",icon: "error",timer: 1500, buttons: false,});</script>');  
    }
    
    
    
}

?>


