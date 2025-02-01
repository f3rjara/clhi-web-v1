<?php 
session_start();

if(isset($_SESSION['logindoc'])){
    header('Location: doic/docente.php');
    exit();
}

if (isset($_POST['consulta']))
{  
    require 'cnxlo.php';  
    
    $id_docente = $conex->real_escape_string($_POST['usuarioPHP']);    
    $clave = md5($conex->real_escape_string($_POST['clavePHP']));
    

    $data = $conex->query("SELECT id_docente FROM docente WHERE id_docente = '".$id_docente."'");    
    
    if ($data->num_rows > 0){
        $_SESSION['logindoc'] = true;
        $_SESSION['docente'] = $id_docente;
        $_SESSION['admin'] = false;
        $_SESSION['verifipw'] = $clave;
        
        if ($id_docente == 1085277365)
        {
            $_SESSION['admin'] = true;
        }
        header("Refresh:1; url=doic/docente.php");
        exit('<script> window.location = "doic/docente.php"; </script>');        
    }     
    else {
        exit('<script> swal({title: "Uppss...!",text: "El usuario o clave son incorrectos '.var_dump($data).'",icon: "error",timer: 2000, buttons: false,});</script>');  
    }
    
    
    
}

?>


