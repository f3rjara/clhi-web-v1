<?php include('../log/cnxlo.php');?> 

<?php
//ACTUALIZACIÓN DE NOTAS
$MensajeActualizacion = false; 

if(isset($_POST['actualizae']) && isset($_POST['correoe']) && isset($_POST['telefonoe']) )
{
    //echo 'Se envio la información';
    $codigoEnviado = $_POST['actualizae'];
    $correoEnviado = $_POST['correoe'];
    $telefonoEnviado = $_POST['telefonoe'];
    
    $_UPDATE_SQL ="UPDATE estudiante SET correo = '".$correoEnviado."', telefono = '".$telefonoEnviado."' WHERE estudiante.codigoe = '".$codigoEnviado."'"; 
    
    
    mysqli_query($conex,$_UPDATE_SQL); 
    
       
    $MensajeActualizacion = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=acerca-de.php');
    
    
}

?>
<!--        ***************** VERIFICAR SI HAY SESION INICIADADA ***************-->
<section>
<?php  
    //    ********************** VERIFICAR SI HAY SESION INICIADAD ***************************
    session_start();
    if (!isset($_SESSION['login']))
    {
        header('location: ../index.php');
    }
    //    ********************** VERIFICAR LA COKKIE PARA PRIMER ANUNCIO **********************
    $exibirModal = false;
    if(!isset($_COOKIE["mostrarModal"]))
    {
        $expirar = 43200;
        setcookie('mostrarModal','SI',(time()+$expirar));
        $exibirModal = true;
    } 
?>
</section>
<!--        ************** FIN VERIFICAR SI HAY SESION INICIADADA  *************-->

<!DOCTYPE HTML>
<html lang="en">

<head>
<title>Acerca de | ToolsTIC v2.1</title> 
<!-- INCLUSION DEL HEADER --> 
<?php include ('../php/headmain.html');?>  
    
<!-- Llamar estilos de sweet Alert  Boostrap y Propios-->
<link rel="stylesheet" type="text/css" href="../css/materialize.css">
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">   

<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Flavors|Grand+Hotel" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Squada+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Advent+Pro" rel="stylesheet">


<!--
font-family: 'Pacifico', cursive;
font-family: 'Flavors', cursive;
font-family: 'Grand Hotel', cursive;
font-family: 'Squada One', cursive;
font-family: 'Advent Pro', sans-serif;

-->
</head>

<body>
<!--        ***************** INCLUSION DEL MENU ***************-->
<?php include('../php/navestu.php');?>  

<?php $EstudianteLogueado = $_SESSION['estudiante']; ?>   


<?php setlocale(LC_ALL,"es_ES");   ?>      
        
<!--        ************* FIN DE INCLUSION DEL MENU ************-->

<?php
//CONSULTAR DATOS DEL ESTUDIANTE INGRESADO Y GRUPO MATRICULADO
    $DatosEstudiante = mysqli_query($conex,
        "SELECT * FROM estudiante, grupo        
        WHERE estudiante.id_grupo = grupo.id_grupo
        AND codigoe = '".$EstudianteLogueado."'");
    while($RCDE = mysqli_fetch_array($DatosEstudiante))
    {
        $codigoEstudiante = $RCDE['codigoe']; 
        $nombreEstudiante = $RCDE['nombre'];
        $apellidoEstudiante = $RCDE['apellido'];
        $detalleGrupo = $RCDE['detalle'];
        $idGrupo =  $RCDE['id_grupo'];  
        $correo = $RCDE['correo'];
        $telefono = $RCDE['telefono'];
        
    } 
?>



<nav class="hide-on-med-and-down greentools">
<div class="nav-wrapper container">
  <ul id="nav-mobile" class="">
        <li><h5 > Grupo: <b> <?php echo $detalleGrupo;?>  </b> | <?php echo $codigoEstudiante;?> | <?php echo utf8_encode($nombreEstudiante);?> <?php echo utf8_encode($apellidoEstudiante);?></h5></li>        
      </ul> &nbsp; &nbsp;
    <img src="../img/usuario2.png" class="circle brand-logo" height="90%" alt=""> 
</div>
</nav>
<div class="progress">
      <div class="indeterminate"></div>
</div>
<br>




 <div class="row container">
    <div class="center">
        <img src="../img/usuario1.png" class="circle sobre-img" alt="" height="20%"> <br>
    </div>
    <br>
    <form class="col s12" method="post" action="acerca-de.php">
      <div class="row">
        <div class="input-field col s12 m6 offset-m3 center sobre-img">
          <input id="codigoes" type="text" class="validate center" disabled name="codigoes" value="<?php echo $codigoEstudiante; ?>">
          <label for="codigoes" class="greentools-text">Código Estudiante</label>
        </div>
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="nombree" type="text" class="validate center" disabled name="nombree" value="<?php echo utf8_encode($nombreEstudiante); ?>">
          <label for="nombree" class="greentools-text">Nombres</label>
        </div>
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="apellidoe" type="text" class="validate center" disabled name="apellidoe" value="<?php echo utf8_encode($apellidoEstudiante); ?>">
          <label for="apellidoe" class="greentools-text">Apellidos</label>
        </div>
        
         
        <div class="input-field col s12 m6 center sobre-img">
          <input id="correoe" type="email" class="validate center tooltipped" data-position="bottom" data-tooltip="Debe ser un correo correcto" name="correoe" placeholder="usuario@correo.com" value="<?php echo $correo; ?>" required>
          <label for="correoe" class="greentools-text">Correo</label>
        </div>
        
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="telefonoe" type="text" class="validate center  tooltipped" data-position="bottom" data-tooltip="Debe ser un número de celular correcto (Sin espacios)" name="telefonoe" value="<?php echo $telefono; ?>" placeholder="3101231234" pattern="[0-9]{10}" required>
          <label for="telefonoe" class="greentools-text">Telefono</label>
        </div>
        
        <div class="input-field col s12 m6 offset-m3 center sobre-img">
           <button class="btn bluetools waves-effect waves-light" type="submit" name="actualizae" value="<?php echo $codigoEstudiante; ?>">Actualizar Información
            <i class="material-icons right">send</i>
          </button>
        </div>
        
      </div>
      
      </div>
    </form>
  </div>
  
  
  
  

<footer class="page-footer bluetools">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 style="font-family: 'Pacifico', cursive"><span class="greenTools-text">Tools</span><span class="redTools-text">Tic</span></h5>
        <p class="grey-text text-lighten-4" style="text-align:center"><span class="greenTools-text">Tools</span><span class="redTools-text">Tic</span> | Módulos de Lenguaje y herramientas informáticas, es una  plataforma para la gestion de notas académicas. <br> Estamos trabajando para      brindar siempre lo mejor
        </p>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Conoce más en</h5>
        
        <ul>
          
          <li><b class="greentools-text">Facebook: </b> <a class="redtools-text" href="https://www.facebook.com/toolstic" target="_blank">@toolstic</a></li>
          <li><b class="greentools-text">Instagram: </b> <a class="redtools-text" href="https://www.instagram.com/toolstic/" target="_blank">@toolstic</a></li>
          <li><b class="greentools-text">Youtube: </b> <a class="redtools-text" href="https://www.youtube.com/playlist?list=PLZcNRnHxdf3Qr2w7DH9CF0sOQGevzGMpO" target="_blank">@ToolsTic</a></li>
          <li><b class="greentools-text">Whatsapp: </b> <a class="redtools-text" href="https://wa.me/573166667795?text=Me%20gustaría%20saber%20más%20sobre%20el%20curso" target="_blank">@ToolsTic</a></li>
          <li><b class="greentools-text">Correo: </b> <a class="redtools-text" href="mailto:toolsticweb@gmail.com" target="_blank">toolsticweb@gmail.com</a></li>
         
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
    © 2018 Copyright
    <a class="grey-text text-lighten-4 right" href="#!">@toolstic</a>
    </div>
  </div>
</footer>
        
        
<!-- *************** AGREGAR JS Y JQUERY **************-->
<section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
   
    <script>
    $(document).ready(function(){
        $('.tooltipped').tooltip();   
        
        $('#Menu_Acerca').addClass('red'); 
        $('#Menu_Acerca2').addClass('red');
        
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });         
        
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($MensajeActualizacion === true ){ ?>        
        swal({
            title: "Correcto!",
            text: "Tú información fue actualizada con exito",
            icon: "success",                
            timer: 2000,
            buttons: false
        });       
    <?php  
        $MensajeActualizacion = false;
        }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
        
    });
    </script>
</section>
<!-- *********** FIN DE AGREGAR JS Y JQUERY ***********-->
</body>
</html>