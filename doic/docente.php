<!--        ***************** VERIFICAR SI HAY SESION INICIADADA ***************-->
<section>
<?php 
    $CambiarPW = false; 
    $exibirModal = false;
    
    //    ********* VERIFICAR SI HAY SESION INICIADAD ************
    session_start();
    if (!isset($_SESSION['logindoc']))
    {
        header('location: ../index.php');
    }
    //    ********* VERIFICAR LA COKKIE PARA PRIMER ANUNCIO *********
    
    if(!isset($_COOKIE["mostrarModal"]))
    {
        $expirar = 43200;
        setcookie('mostrarModal','SI',(time()+$expirar));
        $exibirModal = true;
    } 
    
            
    if(isset($_SESSION['verifipw']))    
    {
        if($_SESSION['verifipw'] == 'a467de8eaf066d026030d1237020ce67')
        {
            $CambiarPW = true;
        }
    }
        
        
?>
</section>
<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->

<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/png" href="../img/favicon.png"/> 
<title>Docente | ToolsTIC v2.1</title> 
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
<?php include('../log/cnxlo.php');?>     
<?php $DocenteLogueado = $_SESSION['docente']; ?>
<?php $EsAdmin = $_SESSION['admin']; ?>
<!--        ************* FIN DE INCLUSION DEL MENU ************-->
<br>     
 
<?php
  
     //CONSULTAR DATOS DEL DOCENTE DE GRUPO
    $DatosDocente = mysqli_query($conex,"SELECT * FROM docente WHERE id_docente = '".$DocenteLogueado."'");
    
    while($RCDD = mysqli_fetch_array($DatosDocente))
    {
        $Documento = $RCDD['id_docente'];
        $nombreDocente = $RCDD['nombre'];
        $apellidoDocente = $RCDD['apellido'];        
        $correo = $RCDD['correo'];        
        $Telefono = $RCDD['telefono'];        
    }
    
    
?>
<div class="row">
   
    <div class="col s12 m4">
        <div class="card-panel bluetools center z-depth-5 ">
        <div class="sobre-img  ">
            <img src="../img/docente.png" class="circle responsive-img " width="40%" alt=""><br>            
            <h5 class="redtools-text" style="font-family: 'Pacifico';"><?PHP echo utf8_encode ($nombreDocente)." ".utf8_encode($apellidoDocente); ?></h5> <span class="white-text"><b>Docente ToolsTic</b></span> <hr>
        </div>         
        
        <span class="white-text">
            <?php
                echo $Documento."<br>";
                echo utf8_encode($correo)."<br>";
                echo $Telefono."<hr>";                
            ?>
            <br><br>
            <div class="sobre-img">
                <a href="perfil.php" class="btn redtools bluetools-text"><b>Editar Perfil</b></a>                
            </div>
            
        </span> 
                            
      </div>
    </div>
    
    
    <div class="col s12 m8">
        <div class="row">
           
            <?php
                //CONSULTAR DATOS DEL NOTICIAS DE TOOLSTIC
                $NoticiasToolstic = mysqli_query($conex,"SELECT * FROM noticiastoolstic ORDER BY fecha DESC ");
                while($RCNTT = mysqli_fetch_array($NoticiasToolstic))
                {
                    setlocale(LC_ALL,"es_ES");                     
            ?>
            <div class="col s12 m12 sobre-img ">
                <div class="card-panel bluetools z-depth-5 hoverable">
                    <code class="greentools-text"><b><?php echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($RCNTT['fecha']))); ?></b></code>
                    <br>    
                    <div class="center"> 
                    <h5 class="redtools-text" style="font-family: 'Pacifico';"><?PHP echo utf8_encode($RCNTT['titulo']);?></h5>
                    </div>
                    <blockquote class="white-text" >  
                        <b><?php echo utf8_encode($RCNTT['mensaje']); ?> </b>
                        <footer class="rigth">— Administración ToolsTic</footer>
                    </blockquote>                    
                </div>
            </div>  
                   
                   
                                        
                      
            
            <?php       
                }            
            ?>
           
              
            
                   
                                 
        </div>
    </div>
    
    
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
            
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });         
        
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($exibirModal === true ){ ?>        
        swal({
            title: "Bienvenido Docente!",
            text: "Ya puedes gestionar tus grupos y actividades...",
            icon: "success",                
            timer: 2000,
            buttons: false
        });       
    <?php   }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
    
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if ($CambiarPW === true ){ ?>        
              setTimeout('CambiarContraseña()',2200);
    <?php   }; $CambiarPW = false; ?>
        
        
        
        
    });
        
    function CambiarContraseña(){     
        swal({
            title: "Cambio de contraseña!",
            text: "Debe Cambiar su contraseña Obligatoriamente...",
            icon: "warning",                
            timer: 2500,
            buttons: false
        }); 
        setTimeout('location.href ="perfil.php"',2500);
    }
        
        
    </script>
</section>
<!-- *********** FIN DE AGREGAR JS Y JQUERY ***********-->
</body>
</html>