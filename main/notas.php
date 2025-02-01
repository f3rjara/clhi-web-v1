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
<title>Notas | ToolsTIC v2.1</title> 
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

<!--        ***************** INCLUSION DEL MENU ***************-->
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

<div class="container">
<ul class="collapsible popout">
<?PHP
    $HayTiposActividades = 0;  
    
    
    //CONSULTAR TIPOS DE ACTIVIDADES POR GRUPO
    $TipoAPG = mysqli_query($conex,"SELECT * FROM tipoactividad, categoriaactividad WHERE tipoactividad.id_grupo = '".$idGrupo."' AND tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad ");
    while($RCTAPG = mysqli_fetch_array($TipoAPG))
    {
        $HayTiposActividades ++;
        $SumaNotaPorActividad = 0; 
        
        $porcentaje = $RCTAPG['porcentaje'];
        $IdTipoActividad = $RCTAPG['id_tipoactividad'];
        $categoriaActividad = $RCTAPG['categoriaActividad']; 
        //echo " *** ".utf8_encode($categoriaActividad)." *** <br>";
?>    
    <li>
        <div class="collapsible-header hoverable">
        <i class="material-icons">assignment</i><b><?php echo $HayTiposActividades." - ".utf8_encode($categoriaActividad); ?> </b> <hr><b>Peso: &nbsp;</b><?php echo $porcentaje;?>%
        </div>
        <div class="collapsible-body">
            <div class="row"> 
<?php      
    $CuantasActividadHay = 0;
    //SUBCONSULTAR DE ACTIVIDADES  POR TIPO DE ACTIVIDAD
    $Actividad = mysqli_query($conex,
        "SELECT * FROM actividad, tipoactividad, modalidad 
        WHERE actividad.id_tipoactividad = '".$IdTipoActividad."'
        AND actividad.id_modalidad = modalidad.id_modalidad 
        AND actividad.id_tipoactividad = tipoactividad.id_tipoactividad 
        ORDER BY actividad.fechaplazo DESC");
        
    while($RCA = mysqli_fetch_array($Actividad))
    {
        $CuantasActividadHay ++;
        
        $id_actividad = $RCA['id_actividad']; 
        $actividad = utf8_encode($RCA['actividad']); 
        $descripcion = utf8_encode($RCA['descripcion']); 
        $fechaplazo = $RCA['fechaplazo']; 
        $linkActividad = $RCA['linkactividad'];        
        $modalidad = $RCA['modalidad']; 
          
        //echo "Id_Actividad = ".$id_actividad."<br>";
        //echo "Actividad = ".$actividad."<br>";
        //echo "descripcion = ".$descripcion."<br>";
        //echo "modalidad = ".$modalidad."<br>";
?>
        <div class="col s12 m12 l6">
            <div class="card bluetools white-text">
                <div class="card-image waves-effect waves-block waves-light container center ">
                    <br><span class="right greentools-text"><?php echo $modalidad; ?></span> <br>
                    <h6><b class="redtools-text"><?php echo $actividad; ?></b></h6>
                    <p><?php echo $descripcion; ?></p>
                </div>

                <div class="card-content greentools ">
                    <span class="card-title activator bluetools white-text btn"><b class="activator">Ver Nota</b><i class="material-icons right medium">send</i></span>
                    <p><a href="<?php echo $linkActividad;?>" class="black-text " target="_blank"><b>ver actividad</b></a></p>
                </div>
                <div class="card-reveal black-text">
                <span class="card-title black-text text-darken-4"><i class="material-icons right">close</i><b><?php echo $actividad; ?></b></span>
                <hr>
            
<?php
        //SUBCONSULTA NOTA POR ACTIVIDAD
        $HayNota = 0;
        
        $NotaxActividad = mysqli_query($conex,
            "SELECT * FROM notas, actividad, estadoactividad, estudiante 
            WHERE notas.id_actividad = actividad.id_actividad
            AND notas.id_estadoactividad = estadoactividad.id_estadoactividad
            AND notas.codigoe = estudiante.codigoe 
            AND notas.codigoe = '".$codigoEstudiante."'
            AND notas.id_actividad = '".$id_actividad."'        
            ORDER BY actividad.fechaplazo DESC");
        
        while($RCNxA = mysqli_fetch_array($NotaxActividad))
        {
            $HayNota ++;
            //echo "****** NOTAS ***+* <br>";
            $IdNota = $RCNxA['id_notas'];
            //echo "Id Actividad = ".$RCNxA['id_actividad']."<br>";
            //echo "Codigoe = ".$RCNxA['codigoe']."<br>";
            $EstadoActividadNota = utf8_encode($RCNxA['estadoactividad']);
            $NotaActividad = number_format($RCNxA['notaactividad'], 2, '.', ''); 
            //echo " *** ".utf8_encode($NotaActividad)." *** <br>";
            $fechaEntrega =$RCNxA['fechaentrega'];
            $fechaCalificada = $RCNxA['fechacalificada'];
            $retroalimentacionNota = utf8_encode($RCNxA['retroalimentacion']);
            
            $SumaNotaPorActividad += $NotaActividad;
                 
?>
            <h5 class="center"><b>Nota: &nbsp; <?php echo $NotaActividad; ?></b></h5>
            <p><b>Fecha Entregada: &nbsp; &nbsp;</b><?php echo strftime("%d de %B del %Y", strtotime($fechaEntrega)); ?>
            <br><b>Fecha Calificada : &nbsp; &nbsp;</b><?php echo strftime("%d de %B del %Y", strtotime($fechaCalificada)); ?></p>
            <p><?php echo $retroalimentacionNota; ?></p>
            <p class="right-align"><b>Estado: &nbsp; &nbsp;</b><span class="btn bluetools"><?php echo $EstadoActividadNota; ?></span>
            </p> 
            <hr>
            <p class="center"><a class="btn" href="buzon.php?token=<?php echo md5($IdNota); ?>&ino=<?php echo $IdNota; ?>" target="_parent">Enviar Mensaje</a></p> 
            
<?php                
        } // FIN DEL WHILE SUBCONSULTA NOTA POR ACTIVIDAD
        if ($HayNota == 0)
        {
            echo '<div class="redtools center container hoverable "> <h6 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>Aún no se registra ningúna nota</b> <hr></h6></div>';
        }
?>   
                </div>
            </div>
        </div> 
        
<?php      
        
    } // FIN DE SUBSONSULTA WHILE ACTIVIDADES POR TIPO DE ACTIVIDADES
    
    
    //******************************************
?> 
            </div>
<?php 
    
    if($CuantasActividadHay>0)
    {
         $TotalNotaXC = number_format(((($SumaNotaPorActividad/$CuantasActividadHay)*$porcentaje)/100), 2, '.', ''); 
         echo '<hr><div class="center"><span><b>Nota final de la categoría:</b> &nbsp;&nbsp; <b> <span class="btn bluetools white-text">&nbsp;'. $TotalNotaXC.' &nbsp; </span> </b></span></div> <hr>';
    }
    else
    {
        $TotalNotaXC = 0;
    }
   
        
    
    //CONSULTA DE TABLA DE NOTA FINAL SI EXISTE 
    $ExisteNota = 0;
    $ExisteRegistroNota = mysqli_query($conex,
        "SELECT * FROM notafinal 
         WHERE codigoe = '".$codigoEstudiante."'
         AND id_tipoactividad = '".$IdTipoActividad."'");
        
    //echo " *** ".utf8_encode($codigoEstudiante)." *** <br>";
    //echo " *** ".utf8_encode($IdTipoActividad)." *** <br>";
    
    while($RCERN = mysqli_fetch_array($ExisteRegistroNota))
        {
            $ExisteNota ++;
            //Update nota
            $_UPDATE_SQL="UPDATE notafinal Set 
            NotaFinalTA ='".$TotalNotaXC."',
            NumActividadesXT = '".$CuantasActividadHay."'
            WHERE 
            codigoe = '".$codigoEstudiante."'
            AND id_tipoactividad= '".$IdTipoActividad."'"; 

            mysqli_query($conex,$_UPDATE_SQL);
        }
    //echo " *** ".utf8_encode($ExisteNota)." *** <br>";
    //echo " *** ".utf8_encode($codigoEstudiante)." *** <br>";
    //echo " *** ".utf8_encode($TotalNotaXC)." *** <br>";
    //echo " *** ".utf8_encode($CuantasActividadHay)." *** <br>";
    
        
    if ($ExisteNota == 0)
    {
        //insert de la nota FINAL DEL ESTUDANTE
          mysqli_query($conex, "INSERT INTO notafinal
          (codigoe,id_tipoactividad,NotaFinalTA,NumActividadesXT) 
            VALUES           ('".$codigoEstudiante."','".$IdTipoActividad."','".$TotalNotaXC."','".$CuantasActividadHay."')"); 
        
    }
       
            
    echo '<div class="center"><span><b>Total de Actividades:</b> &nbsp;&nbsp; <b>'.$CuantasActividadHay.'</b></span></div> <hr>';
?>
        </div>
    </li> <br>
<?php
    }//FIN DEL WHILE DE TIPOS DE ACTIVADES POR GRUPO
?>
<!-- +***************************************************** -->
<?PHP
if($HayTiposActividades == 0)
{
    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>Aún no se registran actividades</b> <hr></h5></div>';
}
else
{
?>   
<li>
    <div class="collapsible-header hoverable bluetools white-text">
         <i class="material-icons">blur_linear</i><b>Nota Final </b> <hr><b>Peso: &nbsp;</b>100 %
    </div>
    <div class="collapsible-body">
        <div class="row">
            <table class="highlight centered responsive-table" >
            <thead class="">
              <tr>
                  <th>Categoria</th>
                  <th>Peso</th>
                  <th>Actividades</th>
                  <th>Nota categoria</th>
              </tr>
            </thead>

            <tbody >
            
            <?php  
            //CONSULTAR LA NOTA POR ACTIVIDADES 
            $HayResultado = 0;
            $NotaDefinitiva = 0;
            $ConultaNotaFinal = mysqli_query($conex,
                "SELECT * FROM notafinal, tipoactividad, categoriaactividad
                WHERE notafinal.codigoe = '".$codigoEstudiante."'
                AND notafinal.id_tipoactividad = tipoactividad.id_tipoactividad
                AND tipoactividad.id_CategoriaActividad = categoriaactividad.id_categoriaActividad");
    
            while($RCCNF = mysqli_fetch_array($ConultaNotaFinal))
            {
                $HayResultado ++;
                $CategoriaactividadNF = $RCCNF['categoriaActividad'];
                $PorcentajeNF = $RCCNF['porcentaje'];
                $TotalActividadesNF = $RCCNF['NumActividadesXT'];
                $NotaFinalNF = $RCCNF['NotaFinalTA'];
                $NotaDefinitiva += $NotaFinalNF;
                
            ?>
            <tr>
            <td><?php echo utf8_encode($CategoriaactividadNF);?></td>
            <td><?php echo $PorcentajeNF;?></td>
            <td><?php echo $TotalActividadesNF;?></td>
            <td><?php echo $NotaFinalNF;?></td>
            </tr>
            
            <?php    
            }
            
            if ($HayResultado == 0)
            {
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>Aún no se registran Notas para el estudiante</b> <hr></h5></div>';
            }
             ?>
            </tbody>
            </table 
        </div>
        <br>
        
        <?php 
             if($NotaDefinitiva > 5)
             {
                 $NotaDefinitiva = 5;
             }
        ?>
        
        
        <div class="center"><b>Nota Final: <br> <span class="btn pulse bluetools white-text">&nbsp; <?php echo $NotaDefinitiva; ?> &nbsp; </span></b></div>
    </div>
</li>

<?php } ?>
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
        
        $('#Menu_Notas').addClass('red'); 
        $('#Menu_Notas2').addClass('red'); 
        
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