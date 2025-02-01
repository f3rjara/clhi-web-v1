<!--        ***************** VERIFICAR SI HAY SESION INICIADADA ***************-->
<section>
<?php  
    //    ********* VERIFICAR SI HAY SESION INICIADAD ************
    session_start();
    if (!isset($_SESSION['login']))
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
?>
</section>
<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->


<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Consulta | ToolsTIC v2.1</title> 
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
<?php include('../php/navestu.php');?>        
<?php include('../log/cnxlo.php');?>     
<?php $EstudianteLogueado = $_SESSION['estudiante']; ?>
<!--        ************* FIN DE INCLUSION DEL MENU ************-->
<br>     
<?PHP
    //CONSULTAR DATOS DEL ESTUDIANTE INGRESADO
    $DatosEstudiante = mysqli_query($conex,"SELECT * FROM estudiante where codigoe = '".$EstudianteLogueado."'");
    while($RCDE = mysqli_fetch_array($DatosEstudiante))
    {
        $codigoEstudiante = $RCDE['codigoe'];
        $NomEstudiante = $RCDE['nombre'];
        $ApellidoEstudiante = $RCDE['apellido'];
        $correoEstudiante =  $RCDE['correo'];
        $telefonoEstudiante = $RCDE['telefono'];    
        $idGrupo =  $RCDE['id_grupo'];
    }  
    
    //CONSULTAR DATOS DEL GRUPO DEL ESTUDIANTE
    $DatosGrupoE = mysqli_query($conex,"SELECT * FROM grupo WHERE id_grupo = '".$idGrupo."'");
    while($RCDGE = mysqli_fetch_array($DatosGrupoE))
    {
       
        $detalleGrupo = $RCDGE['detalle'];
        $yearGrupo = $RCDGE['year'];
        $periodoGrupo =  $RCDGE['periodo'];
        $aulaGrupo = $RCDGE['aula'];    
        $horainicioGrupo =  $RCDGE['horainicio'];
        $horafinGrupo =  $RCDGE['horafin'];
        $idDocenteGrupo =  $RCDGE['id_docente'];
    }
    
     //CONSULTAR DATOS DEL DOCENTE DE GRUPO
    $DatosDocente = mysqli_query($conex,"SELECT * FROM docente WHERE id_docente = '".$idDocenteGrupo."'");
    while($RCDD = mysqli_fetch_array($DatosDocente))
    {
       
        $nombreDocente = $RCDD['nombre'];
        $apellidoDocente = $RCDD['apellido'];        
    }
    
    
?>

<div class="row">
   
    <div class="col s12 m4">
        <div class="card-panel bluetools center z-depth-5 ">
        <div class="sobre-img  ">
            <img src="../img/usuario1.png" class="circle responsive-img " width="40%" alt=""><br>
            <h5 class="redtools-text" style="font-family: 'Pacifico';"><?PHP echo utf8_encode ($NomEstudiante)." ".utf8_encode($ApellidoEstudiante); ?></h5>
        </div>         
        
        <span class="white-text">
            <?php
                echo $codigoEstudiante."<br>";
                echo utf8_encode($correoEstudiante)."<br>";
                echo $telefonoEstudiante."<hr>";
                echo "<b class='greentools-text'>Grupo:</b> ".$detalleGrupo." -- ".$periodoGrupo."-".$yearGrupo."<br>"; 
                echo "<b class='greentools-text'>Aula:</b> ".$aulaGrupo."  Bloque Tecnológico<br>";
                echo "<b class='greentools-text'>Inico:  </b>".$horainicioGrupo."<b class='greentools-text'>&nbsp; &nbsp; &nbsp;Fin:  </b>".$horafinGrupo."<br>";  
                echo "<b class='greentools-text'>Docente:  </b>".$nombreDocente." ".$apellidoDocente;
            ?>
            <br><br>
            <div class="sobre-img">
                <a href="acerca-de.php" class="btn redtools bluetools-text"><b>Editar Perfil</b></a>                
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
            title: "Bienvenido!",
            text: "Ya puedes consultar todas tus notas...",
            icon: "success",                
            timer: 2000,
            buttons: false
        });       
    <?php   }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
        
    });
    </script>
</section>
<!-- *********** FIN DE AGREGAR JS Y JQUERY ***********-->
</body>
</html>