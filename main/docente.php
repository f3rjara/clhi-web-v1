<?php 
    session_start(); 
    if (!isset($_SESSION['logindoc']))
    {
        header('location: ../index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>        
    <!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Docente | ToolsTIC v2.1</title> 
    <!-- INCLUSION DEL HEADER --> 
    <?php include ('../php/headmain.html');?>    
   
    <?php
        $exibirModal = false;
        if(!isset($_COOKIE["mostrarModal"]))
        {
            $expirar = 43200;
            setcookie('mostrarModal','SI',(time()+$expirar));
            $exibirModal = true;
        }
    ?>
</head>

<body class="black white-text">
   <?php 
        echo "usuario: ".$_SESSION['docente'];
        if ($exibirModal === true ){   
   ?>
   <script>
       swal({
            title: "Bienvenido Docente..!",
            text: "Registrar tus notas ahora es mas facil",
            icon: "success",                
            timer: 3500,
            buttons: false              
        });  
    </script>
    <?php }; ?>
  
   
<a href="../log/logout.php"><i class="icon-salir"></i>Cerrar Sesion</a>
            


  

<!--Copyright-->
<section>
<div>
    © 2018 Copyright:
    <a href="https://www.youtube.com/playlist?list=PLZcNRnHxdf3Qr2w7DH9CF0sOQGevzGMpO" target="_blank" title="Proyecto realizaso por @f3rjara">Fernando Jaramillo | <b style="font-family: 'Yatra One', cursive;" >@f3rjara</b>  </a>
</div>
</section>
<!--/Copyright-->

<!-- *************** AGREGAR JS Y JQUERY **************-->
<section>
    
</section>
<!-- *************** FIN DE AGREGAR JS Y JQUERY **************-->

</body>
</html>