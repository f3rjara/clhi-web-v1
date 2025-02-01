<?php include('../log/cnxlo.php');?>  


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
    $MensajeAFIRMA = false;
    
    if(!isset($_COOKIE["mostrarModal"]))
    {
        $expirar = 43200;
        setcookie('mostrarModal','SI',(time()+$expirar));
        $exibirModal = true;
    } 
    
    if(isset($_GET['id_in']) && isset($_GET['delete']))
{
    if($_GET['delete'] == '099af53f601532dbd31e0ea99ffdeb64')
    {
        $EliminaMensaje =  "DELETE FROM interpelar WHERE id_interpela = '".$_GET['id_in']."'";
        mysqli_query($conex,$EliminaMensaje); 
        $MensajeAFIRMA = true;
        header('Refresh: 2; URL=buzon.php');
    }
}
    
    
?>
</section>
<!--        ************** FIN VERIFICAR SI HAY SESION INICIADADA  *************-->

<!DOCTYPE HTML>
<html lang="en">

<head>
<title>Buzon | ToolsTIC v2.1</title> 
<!-- INCLUSION DEL HEADER --> 
<?php include ('../php/headmain.html');?>  
    
<!-- Llamar estilos de sweet Alert  Boostrap y Propios-->
<link rel="stylesheet" type="text/css" href="../css/materialize.css">
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">   

</head>

<body class="fondochat">

<!--        ***************** INCLUSION DEL MENU ***************-->
<?php include('../php/navestu.php');?> 
 
<?php $EstudianteLogueado = $_SESSION['estudiante']; ?>  
<?php setlocale(LC_ALL,"es_CO");   ?>         
     
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


$hoy = getdate();
$fecha = $hoy['year']."-".$hoy['mon']."-".($hoy['mday']);



//SE MUESTRA EL MENSAJE
if(isset($_GET['status']))
{    
    $StatusMsj = $_GET['status'];
}

?>




<!--        ************* FIN DE INCLUSION DEL MENU ************-->


<?php
 
// SE ENVIA DATOS DEL FORMULARIO PARA INTERPELAR NOTA    
if(isset($_POST['btnmsj']) && isset($_POST['msjnota']))
{
    $IdNotaGet = $_POST['btnmsj'];
    $MensajeNota = utf8_decode($_POST['msjnota']);
    
    //INSERTAR EL MENSAJE DEL USUARIO
    mysqli_query($conex, 
    "INSERT INTO interpelar
    (observacion,fechasolicitud,id_notas,id_estadointerpela) 
    VALUES 
    ('$MensajeNota','$fecha','$IdNotaGet','1')");

    //header('Location: /buzon.php?status=true');
    header('Refresh: 0; URL=buzon.php?status=true');
}


// SE ACTIVA O NO EL FORMULARIO
if(isset($_GET['token']) && isset($_GET['ino'])){    
   $yainterpelo = 0;
    //CONSULTAR DATOS DE INTEPERLA EN UNA NO
    $DatosInterpela = mysqli_query($conex,
        "SELECT * FROM interpelar, estadointerpela        
        WHERE interpelar.id_notas = '".$_GET['ino']."'
        AND interpelar.id_estadointerpela = estadointerpela.id_estadointerpela");
    while($RCDIN = mysqli_fetch_array($DatosInterpela))
    {        
        $yainterpelo ++;
        //header('Location: /buzon.php?status=true');
        header('Refresh: 0; URL=buzon.php?status=false');       
    } 
    
  
    if($yainterpelo == 0)
    {
        
        
    $DatosActividad2 = mysqli_query($conex,
        "SELECT * FROM actividad, notas       
        WHERE notas.id_notas = '".$_GET['ino']."'
        AND notas.id_actividad = actividad.id_actividad");
    while($RCDAC = mysqli_fetch_array($DatosActividad2))
    {        
        $ActvidadDetalle = utf8_decode($RCDAC['actividad']);
        $DescActvidadDetalle = utf8_decode($RCDAC['descripcion']);
        $NotaActvidadDetalle = $RCDAC['notaactividad'];  
    } 
        
?>
<div class="row container">
    <div class="col s12 m12">
      <div class="card bluetools white-text">
        <div class="card-content white-text">
            <span class="card-title"><b class="redtools-text">Interpelación a nota de Actividad </b> </span> <hr>            
            <div class="row">
                <div class="col s12 m6">
                    <b class="greentools-text">Actividad : </b> <?php echo $ActvidadDetalle; ?> <br>
                    <b class="greentools-text">Descripción : </b> <?php echo $DescActvidadDetalle; ?><br>
                    <b class="greentools-text">Nota : </b><?php echo $NotaActvidadDetalle; ?>
                </div>
                
                <div class="col s12 m6">
                    <b class="greentools-text">Código Estudiante : </b> 2130102135 <br>
                    <b class="greentools-text">Nombre : </b> Fernando Jaramillo <br>
                    <b class="greentools-text">Grupo : </b> G17
                </div>
            </div>
            <hr>
            <span>* A continuación digite el mensaje con su reclamo, queja, sugerencia, observación o comentario acerca de la nota de la presente actividad; una vez enviadoa el mensaje el docente dará una respuesta lo más pronto posible.</span> <br>
            
            <div class="row">
                <form class="col s12" method="post" action="buzon.php">
                    <div class="row">
                        <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                        <textarea id="icon_prefix2" class="materialize-textarea white-text" name="msjnota" required  data-error="Obligatorio" data-length="200" maxlength="200" ></textarea>
                        <label for="icon_prefix2">Mensaje</label>
                        </div>
                        
                        <button class="btn input-field col s12 m6 right redtools black-text" type="submit" name="btnmsj" value="<?php echo $_GET['ino']; ?>"><b>Enviar Mensaje</b>
                            <i class="material-icons right">send</i>
                        </button>                   
                    </div>
                </form>
            </div>
        </div>        
      </div>
    </div>
</div>       
<?php    
    }
    
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
<div class="row">
   <br> 
<?php
//echo strftime("%d de %B del %Y", strtotime($fecha));
    

$HayInterpelaciones = 0;
//CONSULA DE INTERPELA DEL ESTUDIANTE 
$InterpelaEstudiante = mysqli_query($conex,
    "SELECT * FROM interpelar, estadointerpela, actividad, notas, estudiante, estadoactividad     
    WHERE interpelar.id_notas = notas.id_notas
    AND interpelar.id_estadointerpela = estadointerpela.id_estadointerpela
    AND notas.id_estadoactividad = estadoactividad.id_estadoactividad
    AND notas.id_actividad = actividad.id_actividad
    AND notas.codigoe = estudiante.codigoe
    AND notas.codigoe = '".$codigoEstudiante."'
    ORDER BY interpelar.fechasolicitud DESC");
 
while($RCIET = mysqli_fetch_array($InterpelaEstudiante))
{
    $HayInterpelaciones ++;
    $Id_Interpela = $RCIET['id_interpela'];         
    $ObservacionInterpela = utf8_encode($RCIET['observacion']); 
    $fechaInterpelaSolicita = $RCIET['fechasolicitud']; 
    $IdNotaInterpela = $RCIET['id_notas'];
    $EstadoInterpela = utf8_encode($RCIET['estado']); 
    $IdActividad = $RCIET['id_actividad']; 
    $ActividadInterpela = $RCIET['actividad']; 
    $DescActividad = utf8_encode($RCIET['descripcion']); 
    $NotaActividadInterpela = $RCIET['notaactividad'];     
    
    
?>

    <div class="row">
        <div class="col s12 m6">
            <div class="chip hoverable z-depth-1 bluetools white-text chipsIzquierda">
            <img src="../img/usuario2.png"  alt="Contact Person">
            <p><b class="greentools-text">Actividad:</b> <?php echo utf8_encode($ActividadInterpela); ?> <br> <b class="greentools-text">Descripción: </b> <?php echo htmlentities($DescActividad); ?></b> <br> <b class="greentools-text">Nota Actividad: </b> <span class="btn redtools black-text">&nbsp; <?php echo $NotaActividadInterpela; ?> &nbsp; </span> 
            </p>
            </div>
        </div>
    </div>
  
    <div class="row">
        <div class="col s12 m6 ">
       <div class="chip hoverable z-depth-1 bluetools white-text chipsIzquierda">
        <img src="../img/usuario2.png"  alt="Contact Person">
        <p> <?php echo htmlentities($ObservacionInterpela); ?></p>
        </div>
        <div class="right-align"> 
        <input type="checkbox" checked="checked" disabled="disabled" />
        <span>Enviado</span>
        &nbsp; <a href="buzon.php?delete=099af53f601532dbd31e0ea99ffdeb64&id_in=<?php echo $Id_Interpela;?>" class="tooltipped" data-position="right" data-tooltip="Eliminar Mensaje"> <i class='material-icons red-text '>delete_forever</i></a>
        </div>        
       </div>
    </div>
   
    <div class="row">
    <div class="col s12 m6 offset-m6 right-align">   
        <input type="checkbox" checked="checked" disabled="disabled" />
        <span>Entregado: <b> <?php echo strftime("%d-%B-%Y", strtotime($fechaInterpelaSolicita)); ?> </b></span>         
        
    </div>
    </div> 
    
    
    
    
<?php    
    $HayRespuestaInterpela = 0;
    
    $RespuestaInterpelaConsulta = mysqli_query($conex,
    "SELECT * FROM interpelar, reinterpelar    
    WHERE interpelar.id_interpela = reinterpelar.id_interpelar
    AND reinterpelar.id_interpelar = '".$Id_Interpela."'");
    
   
    while($RCRI = mysqli_fetch_array($RespuestaInterpelaConsulta))
    {
        $HayRespuestaInterpela ++;
        $ID_REINTERPELA = $RCRI['id_reinterpela']; 
        $ID_DOCENTE = $RCRI['id_docente']; 
        $ID_INTERPELAR = $RCRI['id_interpelar']; 
        $ID_ESTADOINTERPELA = $RCRI['id_estadointerpela']; 
        $OBSERVACION = $RCRI['observacion']; 
        $FECHA_RESPUESTA = $RCRI['fechaRespuesta']; 
        
        ?>
        
         <div class="row">
            <div class="col s12 m6 offset-m6">
               <div class="chip hoverable z-depth-1 greentools white-text chipsDerecha">
                <img src="../img/favicon.png" width="100%" >
                <p> <?php echo utf8_encode($OBSERVACION);?></p>
                </div>
                <div class="right-align">
                    <input type="checkbox" checked="checked" disabled="disabled" />
                    <span>Respuesta: <b><?php echo strftime("%d-%B-%Y", strtotime($FECHA_RESPUESTA)); ?></b></span>
                </div>

           </div>
         </div>
       
        
        <?php
        
    }
    
    if($HayRespuestaInterpela == 0)
    {
        echo "<div class='right-align'><p><hr> ESPERANDO  RESPUESTA <hr> </p> </div>";
    }
    
    
    
    
} 
    
?> 
</div>  
<?php    
if ($HayInterpelaciones == 0)
{
    //echo '<hr><b class="bluetools-text flow-text">El estudiante no tiene mensaje registrados</b><hr>';
?>
    <div class="row">
    <br>
    <div class="row">
        <div class="col s12 m6 offset-m6">
            <div class="chip hoverable z-depth-1 greentools white-text chipsDerecha">
            <img src="../img/favicon.png" >
            <h5 class="black-text"> Aún no se ha enviado ningun mensaje</h5>
            </div>
            <div class="right-align">
            <input type="checkbox" checked="checked" disabled="disabled" />
                <span>Enviado: <b><?php echo strftime("%d-%B-%Y", strtotime($fecha)); ?></b></span>
            </div>
        </div>
    </div>
    </div>
<?php
                
}
?>

</div>




   
    
   

  


<!-- *************** AGREGAR JS Y JQUERY **************-->
<section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
   
   <script>
    $(document).ready(function(){            
       
        $('.tooltipped').tooltip();
        
        $('#Menu_Buzon').addClass('red'); 
        $('#Menu_Buzon2').addClass('red'); 
        
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });         
                
        
    // <!--        ***************** MODAL WELCOME COOKIE ***************-->
    <?php if (isset($_GET['status']) && $StatusMsj == 'true'){ ?>        
        swal({
            title: "Regsitrado!",
            text: "El mensaje fue registrado con exito...",
            icon: "success",                
            timer: 2000,
            buttons: false
        });       
    <?php   }; ?>
        
    <?php if (isset($_GET['status']) && $StatusMsj == 'false'){    ?>        
        swal({
            title: "Comprueba!",
            text: "Ya enviaste un mensaje de la nota, espera la respuesta del docente o consulta su estado...",
            icon: "warning",                
            timer: 3000,
            buttons: false
        });       
    <?php   }; ?>        
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
        
        $('textarea#icon_prefix2').characterCounter();
        
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
      
        
        
    });  
    
   
    </script>
    
</section>
<!-- *********** FIN DE AGREGAR JS Y JQUERY ***********-->
</body>
</html>