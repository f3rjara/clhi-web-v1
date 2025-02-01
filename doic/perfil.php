<?php include('../log/cnxlo.php');?>     

<!--        ***************** VERIFICAR SI HAY SESION INICIADADA ***************-->
<section>
<?php  
    //    ********* VERIFICAR SI HAY SESION INICIADAD ************
    session_start();
    if (!isset($_SESSION['logindoc']))
    {
        header('location: ../index.php');
    }
    //    ********* VERIFICAR LA COKKIE PARA PRIMER ANUNCIO *********
    $exibirModal = false;
    if(!isset($_COOKIE["mostrarModal"]))
    {
        $expirar = 43200;
        setcookie('mostrarModal','SI',(time()+$expirar));
        $exibirModal = true;
    } 
    $MensajeAFIRMA = false;  
    $MensajeError = false;  
    $CambioPW = false;  
?>
<?php $DocenteLogueado = $_SESSION['docente']; ?>
<?php $EsAdmin = $_SESSION['admin']; ?>

<?PHP
    
if(isset($_POST['AIDD'])){
    //CONSULTAR PW
    $CONSULTA = mysqli_query($conex,
        "SELECT clave FROM docente WHERE id_docente = '".$DocenteLogueado."'");
    
    while($RCC = mysqli_fetch_array($CONSULTA))
    {
        $SuClave = $RCC['clave'];
    }
    
    if(md5($_POST['PassOld']) == $SuClave ) {        
    
        if($_POST['PassNew'] != "")
        {
            //ACTUALIZAR  correoDO telefonoDO PassOld PassNew 
            $ActualizaDocente="UPDATE docente Set 
            correo='".$_POST['correoDO']."', 
            telefono='".$_POST['telefonoDO']."',
            clave='".md5($_POST['PassNew'])."'

            WHERE id_docente='".$DocenteLogueado."'"; 

            mysqli_query($conex,$ActualizaDocente);
            $MensajeAFIRMA = true;
            header('Refresh: 2; URL=perfil.php');

            $CambioPW = true;
        }
        else
        {
            //ACTUALIZAR  correoDO telefonoDO PassOld PassNew 
            $ActualizaDocente="UPDATE docente Set 
            correo='".$_POST['correoDO']."', 
            telefono='".$_POST['telefonoDO']."'

            WHERE id_docente='".$DocenteLogueado."'"; 

            mysqli_query($conex,$ActualizaDocente);
            $MensajeAFIRMA = true;
            header('Refresh: 2; URL=perfil.php');
        }
    }
    else
    {
        $MensajeError = true;
    }
}
        
            
?>
</section>
<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->

<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/png" href="../img/favicon.png"/> 
<title>Perfil | ToolsTIC v2.1</title> 
<!-- INCLUSION DEL HEADER --> 
<?php include ('../php/headmain.html');?>  

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
 
<!-- Llamar estilos de sweet Alert  Boostrap y Propios-->
<link rel="stylesheet" type="text/css" href="../css/materialize.css">
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">   
   
</head>

<body>
<!--        ***************** INCLUSION DEL MENU Y CONEXION ***************-->
<?php include('../php/navdoce.php');?>        

<!--        ************* FIN DE INCLUSION DEL MENU ************-->
<?php
//CONSULTAR DATOS DEL DOCENTE INGRESADO
$DatosDocente = mysqli_query($conex,"SELECT * FROM docente WHERE id_docente = '".$_SESSION['docente']."'");
while($RCDD = mysqli_fetch_array($DatosDocente))
{
    $Id_Docente = $RCDD['id_docente'];
    $NomDocente = $RCDD['nombre'];
    $ApellDocente = $RCDD['apellido'];
    $correoDocente =  $RCDD['correo'];
    $telefonoDocente = $RCDD['telefono'];   
}    
?>
 
<nav class="hide-on-med-and-down greentools">
    <div class="nav-wrapper container">
      <ul id="nav-mobile" class="">
        <li><h5> <b class="bluetools-text"> Docente: </b> <?php echo $Id_Docente;?> | <?php echo $NomDocente;?> <?php echo $ApellDocente;?></h5></li>        
      </ul> &nbsp; &nbsp;
        <img src="../img/docente.png" class="circle brand-logo" height="90%" alt=""> 
    </div>
</nav>
<br>
<!--        ************* INICIO DEL BOODY ************-->
    



 <div class="row container">
    <div class="center">
        <img src="../img/docente.png" class="circle sobre-img" alt="" height="30%"> <br>
    </div>
    <br>
    <form class="col s12" method="post" action="perfil.php">
      <div class="row">
        <div class="input-field col s12 m6 offset-m3 center sobre-img">
          <input id="codigoDO" type="text" class="validate center" disabled name="codigoDO" value="<?php echo $Id_Docente; ?>">
          <label for="codigoDO" class="greentools-text">Docente</label>
        </div>
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="nombreDO" type="text" class="validate center" disabled name="nombreDO" value="<?php echo utf8_encode($NomDocente); ?>">
          <label for="nombreDO" class="greentools-text">Nombres</label>
        </div>
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="apellidoDO" type="text" class="validate center" disabled name="apellidoDO" value="<?php echo utf8_encode($ApellDocente); ?>">
          <label for="apellidoDO" class="greentools-text">Apellidos</label>
        </div>
        
         
        <div class="input-field col s12 m6 center sobre-img">
          <input id="correoDO" type="email" class="validate center tooltipped" data-position="bottom" data-tooltip="Debe ser un correo correcto" name="correoDO" placeholder="usuario@correo.com" value="<?php echo $correoDocente; ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
          <label for="correoDO" class="greentools-text">Correo</label>
        </div>
        
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="telefonoDO" type="text" class="validate center  tooltipped" data-position="bottom" data-tooltip="Debe ser un número de celular correcto (Sin espacios)" name="telefonoDO" value="<?php echo $telefonoDocente; ?>" placeholder="3101231234" pattern="[0-9]{10}" required>
          <label for="telefonoDO" class="greentools-text">Telefono</label>
        </div>
        
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="PassOld" type="password" class="validate center  tooltipped" data-position="top" data-tooltip="Coloque su antigua contraseña" name="PassOld" required>
          <label for="PassOld" class="redtools-text"><b>Contraseña anterior</b></label>
        </div>
        
        
        <div class="input-field col s12 m6 center sobre-img">
          <input id="PassNew" type="password" onclick="M.toast({html: 'Una vez cambie su clave debe volver a iniciar sesión', classes: 'rounded'})" class="validate center  tooltipped" data-position="top" data-tooltip="Minimo 6 caracteres | Debe contener una Mayuscula" name="PassNew" pattern="(?=.*[A-Z]).{6,}">
          <label for="PassNew" class="greentools-text"><b>Nueva Contraseña</b></label>
        </div>
        
        
        <div class="input-field col s12 m6 offset-m3 center sobre-img">
           <button class="btn bluetools waves-effect waves-light" type="submit" name="AIDD" value="<?php echo $Id_Docente; ?>">Actualizar Información
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
        $('.sidenav').sidenav();
        $('.tooltipped').tooltip();
        $('#Menu_Acerca').addClass('red'); 
        $('#Menu_Acerca2').addClass('red'); 
        $(".dropdown-trigger").dropdown();
        
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });   
        
        
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($exibirModal === true ){ ?>        
        swal({
        title: "Bienvenido Docente..!",
        text: "Registrar tus notas !ahora es mas facil¡",
        icon: "success",                
        timer: 3500,
        buttons: false              
        });         
    <?php   }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
    
        
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($MensajeAFIRMA == true ){ ?>        
        swal({
        title: "Correcto..!",
        text: "La acción fue registrada con exito..!",
        icon: "success",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $MensajeAFIRMA = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
    
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($MensajeError == true ){ ?>        
        swal({
        title: "Error..!",
        text: "La contraseña antigua no es correcta..!",
        icon: "warning",                
        timer: 1500,
        buttons: false              
        });         
    <?php  $MensajeError = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
    
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($CambioPW == true ){ ?>        
        swal({
        title: "Se cambio la contraseña..!",
        text: "Debe volver a iniciar sesión..!",
        icon: "info",                
        timer: 3000,
        buttons: false              
        }); 
        setTimeout('location.href ="../log/logout.php"',3100);
    <?php  $CambioPW = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
    
    });
        
    
    </script>
</section>
<!-- *************** FIN DE AGREGAR JS Y JQUERY **************-->
</body>
</html>