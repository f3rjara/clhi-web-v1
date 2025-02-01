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
<!--        ***************** INCLUSION DEL MENU  Y CONEXION ***************-->
<?php include('../php/navestu.php');?>    
<?php include('../log/cnxlo.php');?>   
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
  
  
<br>


<div class="row container ">
    <ul class="collapsible popout">
    
<?php
$HayTiposActividades = 0;
//CONSULTAR TIPOS DE ACTIVIDADES POR GRUPO
$TipoAPG = mysqli_query($conex,"SELECT * FROM tipoactividad, categoriaactividad WHERE tipoactividad.id_grupo = '".$idGrupo."' AND tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad ");
while($RCTAPG = mysqli_fetch_array($TipoAPG))
{
    $HayTiposActividades ++;
    $porcentaje = $RCTAPG['porcentaje'];
    $IdTipoActividad = $RCTAPG['id_tipoactividad'];
    $categoriaActividad = $RCTAPG['categoriaActividad'];   
    
?>
   <li>
          <div class="collapsible-header hoverable"><i class="material-icons">assignment</i><b><?php echo $HayTiposActividades." - ".utf8_encode($categoriaActividad); ?> </b> <hr><b>Peso: &nbsp;</b><?php echo $porcentaje; ?>%</div>
          <div class="collapsible-body">              
              <div class="row">
<?PHP    
    
    $CuantasActividadHay = 0;
    
    
    //SUBCONSULTAR DE ACTIVIDADES  POR TIPO DE ACTIVIDAD
    $Actividad = mysqli_query($conex,"SELECT * FROM actividad, tipoactividad, modalidad WHERE actividad.id_tipoactividad = '".$IdTipoActividad."'AND actividad.id_modalidad = modalidad.id_modalidad AND actividad.id_tipoactividad = tipoactividad.id_tipoactividad ORDER BY actividad.fechaplazo DESC");
    while($RCA = mysqli_fetch_array($Actividad))
    {
        $CuantasActividadHay ++;
        //echo '<div class="center"><span><b>Total de Actividades:</b> &nbsp;&nbsp; <b>'.$CuantasActividadHay.'</b></span></div> <hr>';
        $id_actividad = $RCA['id_actividad']; 
        $actividad = utf8_encode($RCA['actividad']); 
        $descripcion = utf8_encode($RCA['descripcion']); 
        $fechaplazo = $RCA['fechaplazo']; 
        $linkActividad = $RCA['linkactividad'];
        //$id_tipoactividad = $RCA['id_tipoactividad']; 
        $modalidad = $RCA['modalidad']; 
          
        
?>
    <div class="col s12 m12 l6 hoverable">   
        <div class="card horizontal bluetools ">      
          <div class="card-stacked ">       
            <div class="card-content white-text">
                <span class="right"><?php echo $modalidad; ?></span> <br>
                <h5 class="redtools-text center"><?php echo $actividad; ?></h5>
                    <p>
                        <?php echo $descripcion; ?>              
                    </p> 
                    <hr>
                    <p class="right">              
                    Plazo de entrega: <span class="btn white bluetools-text"><b><?php echo strftime("%d de %B del %Y", strtotime($fechaplazo)); ?></b></span>
                    </p>
                </div>
                <div class="card-action center">                    
                    <a href="<?php echo $linkActividad; ?>" target="_blank" class="btn greentools bluetools-text efectosubir"><b>Ver Actividad</b></a>  
                </div>
          </div>
        </div>
    </div>
                  
<?php
        
        
    } // FIN WHILE DE ACTIVIDADES POR TIPO
    
   echo '
                </div>
               <div class="center"><span><b>Total de Actividades:</b> &nbsp;&nbsp; <b>'.$CuantasActividadHay.'</b></span></div> <hr>
            </div>
        </li> <br> ';
         
} //FIN WHILE TIPOS DE ACTIVIDADES POR GRUPOS

if($HayTiposActividades == 0)
{
    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El grupo no tiene actividades creadas por el docente</b> <hr></h5></div>';
}
        
        
?>

               
    </ul>
</div>



<!-- *************** AGREGAR JS Y JQUERY **************-->
<section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
   
    <script>
    $(document).ready(function(){
        
        $('#Menu_Actividades').addClass('red'); 
        $('#Menu_Actividades2').addClass('red'); 
        
        
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
        
        $('.collapsible').collapsible();
        
    });
    </script>
</section>
<!-- *********** FIN DE AGREGAR JS Y JQUERY ***********-->

        





</body>
</html>