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
?>
</section>
<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->
<?php $DocenteLogueado = $_SESSION['docente']; ?>
<?php $EsAdmin = $_SESSION['admin']; ?>

<?PHP
$hoy = getdate();
$fecha = $hoy['year']."-".$hoy['mon']."-".($hoy['mday']);
$MensajeAFIRMA = false;

if(isset($_POST['IDRI']))
{
    
    $Id_Interpela = $_POST['IDRI'];
    $Respuesta = utf8_decode($_POST['resinterpela']);
    
    //INSERTAR
    mysqli_query($conex, 
    "INSERT INTO reinterpelar 
    (id_docente,id_interpelar,id_esatdointerpela,observacion,fechaRespuesta) 
    values 
    ('".$DocenteLogueado."','".$Id_Interpela."','3','".$Respuesta."','".$fecha."')");
    
    $MensajeAFIRMA = true;
    header('Refresh: 2; URL=buzondoc.php');
}

if(isset($_GET['id_rei']) && isset($_GET['delete']))
{
    if($_GET['delete'] == '099af53f601532dbd31e0ea99ffdeb64')
    {
        $EliminaMensaje =  "DELETE FROM reinterpelar WHERE id_reinterpela = '".$_GET['id_rei']."'";
        mysqli_query($conex,$EliminaMensaje); 
        $MensajeAFIRMA = true;
        header('Refresh: 2; URL=buzondoc.php');
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/png" href="../img/favicon.png"/> 
<title>Buzon | ToolsTIC v2.1</title> 
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
<?php include('../php/navdoce.php');    
setlocale(LC_ALL,"es_CO");       
$hoy = getdate();
$fecha = $hoy['year']."-".$hoy['mon']."-".($hoy['mday']);
?>        

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
<?php
$arrayGruposDocente = array();  
$ElDocenteTieneGrupos = 0;
    
//CONSULTA DE GRUPOS DEL DOCENTE
$GruposDocente = mysqli_query($conex,
    "SELECT * FROM grupo, docente
    WHERE grupo.id_docente  = docente.id_docente 
    AND grupo.id_docente = '".$DocenteLogueado."'");

while($RCGXD = mysqli_fetch_array($GruposDocente))
{
    $ElDocenteTieneGrupos ++;
    //($RCGXD['id_grupo'], $RCGXD['detalle'] , $RCGXD['id_docente'])
    $arrayGruposDocente[] = array($RCGXD['id_grupo'], $RCGXD['detalle'], $RCGXD['aula']);
}

if ($ElDocenteTieneGrupos == 0){
    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El docente no tiene grupos asignados</b></h5> <b> Comuniquese con el administrador del sitio para solicitar un grupo</b></div>';
}
else { ?>
    <ul class="collapsible popout">    
    <?php for($i = 0; $i < $ElDocenteTieneGrupos ; $i ++){
    //IDE DEL GRUPO -> echo $arrayGruposDocente[$i][0]."<br>";
    //DETALLE DEL GRUPO -> echo $arrayGruposDocente[$i][1]."<br>";
    //AULA GRUPO -> echo $arrayGruposDocente[$i][2]."<hr>"; ?>
    <li>

    <div class="collapsible-header"><i class="material-icons">assistant_photo</i><b>Grupo:</b> &nbsp; <b class="greentools-text"> <?php echo $arrayGruposDocente[$i][1]; ?> </b><hr><b class="greentools-text">Aula : </b>&nbsp;<b><?php echo $arrayGruposDocente[$i][2]; ?></b></div>

    <div class="collapsible-body">
    
    <?php
        $HayMensajes = 0;
        $BuscarMensajeGrupo = mysqli_query($conex,
            "SELECT estudiante.codigoe,estudiante.nombre,estudiante.apellido 
            FROM interpelar, notas, estudiante
            WHERE interpelar.id_notas = notas.id_notas
            AND notas.codigoe = estudiante.codigoe            
            AND estudiante.id_grupo = '".$arrayGruposDocente[$i][0]."'
            GROUP BY notas.codigoe
            ORDER BY notas.codigoe ASC"); ?>
        <ul class="collapsible">     
    <?php while ($RCBMXG = mysqli_fetch_array($BuscarMensajeGrupo))
        {
            $HayMensajes++;
            $codigoes= $RCBMXG['codigoe'];
            $nombrees= utf8_encode($RCBMXG['nombre']);
            $apellidoes = utf8_encode($RCBMXG['apellido']);            
        ?>    
        
            <li>
                <div class="collapsible-header"><i class="material-icons">message</i><b><?php echo $nombrees." ".$apellidoes;?></b><hr><b class="greentools-text">Código:</b>&nbsp;<b><?php echo $codigoes; ?></b></div>
                <div class="collapsible-body">
            <?php    
                $VerInterpelacionEstudiante = mysqli_query($conex,
                    "SELECT * FROM interpelar,notas,actividad
                    WHERE interpelar.id_notas = notas.id_notas
                    AND notas.id_actividad = actividad.id_actividad 
                    AND notas.codigoe = '".$codigoes."'
                    ORDER BY interpelar.fechasolicitud DESC");    
                
                while($RCVIDE = mysqli_fetch_array($VerInterpelacionEstudiante))
                {
                ?>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="chip hoverable z-depth-1 bluetools white-text chipsIzquierda">
                        <img src="../img/usuario2.png"  alt="Contact Person">
                        <p><b class="greentools-text">Actividad:</b> <?php echo utf8_encode($RCVIDE['actividad']); ?> <br> <b class="greentools-text">Descripción: </b> <?php echo utf8_encode($RCVIDE['descripcion']); ?></b> <br> <b class="greentools-text">Nota Actividad: </b> <span class="btn redtools black-text">&nbsp; <?php echo $RCVIDE['notaactividad']; ?> &nbsp; </span> 
                        </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 ">
                   <div class="chip hoverable z-depth-1 bluetools white-text chipsIzquierda">
                    <img src="../img/usuario2.png"  alt="Contact Person">
                    <p> <?php echo utf8_encode($RCVIDE['observacion']); ?></p>
                    </div>
                    <div class="right-align"> 
                    <input type="checkbox" checked="checked" disabled="disabled" />
                    <span>Enviado</span>
                    </div>        
                   </div>
                </div>

                <div class="row">
                <div class="col s12 m6 offset-m6 right-align">   
                    <input type="checkbox" checked="checked" disabled="disabled" />
                    <span>Entregado: <b> <?php echo strftime("%d-%B-%Y", strtotime($RCVIDE['fechasolicitud'])); ?> </b></span> 
                </div>
                </div>  
                          
                          
                           
                <?php    $HayRespuesta = 0;
                    
                    $ConultaRespuesta = mysqli_query($conex,
                        "SELECT * FROM reinterpelar
                        WHERE id_interpelar = '".$RCVIDE['id_interpela']."'");
                    
                    while($RCCRI = mysqli_fetch_array($ConultaRespuesta))
                    {
                        $HayRespuesta ++;                        
                    ?>    
                    <div class="row">
                    <div class="col s12 m6 offset-m6">
                       <div class="chip hoverable z-depth-1 greentools white-text chipsDerecha">
                        <img src="../img/favicon.png" width="100%" >
                        <p> <?php echo utf8_encode($RCCRI['observacion']);?>  </p> 
                        </div>
                        <div class="right-align">
                            
                            <input type="checkbox" checked="checked" disabled="disabled" />
                            <span>Respuesta: <b><?php echo strftime("%d-%B-%Y", strtotime($RCCRI['fechaRespuesta'])); ?></b></span>
                            &nbsp;
                            <a href="buzondoc.php?delete=099af53f601532dbd31e0ea99ffdeb64&id_rei=<?php echo $RCCRI['id_reinterpela'];?>" class="tooltipped" data-position="bottom" data-tooltip="Eliminar Mensaje"> <i class='material-icons red-text '>delete_forever</i></a> &nbsp;
                        </div>

                    </div>
                    </div>
       
                   
                    <?php }
                    
                    if($HayRespuesta == 0)
                    { ?>
                    <hr>
                       <div class="col s12 m6 offset-m6 right-align">
                        <a href="#modal<?php echo $RCVIDE['id_interpela'];?>" class="waves-effect waves-light btn modal-trigger ">Agregar Respuesta</a>
                        </div>
                    <hr>
                    <?php }
                    
                    ?>
                
                  <!-- Modal Structure -->
                  <div id="modal<?php echo $RCVIDE['id_interpela'];?>" class="modal modal-fixed-footer">
                    <div class="modal-content">
                      <h5>Se enviara respuesta a <b><?php echo $nombrees." ".$apellidoes;?></b></h5><hr>
                      <p class="center"><b>Actividad: </b><?php echo utf8_encode($RCVIDE['actividad']);?> <br><?php echo utf8_encode($RCVIDE['observacion'])?> </p> <hr>
                                          
                    <div class="row">
                    <form class="col s12" action="buzondoc.php" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                          <i class="material-icons prefix">mode_edit</i>
                          <textarea id="icon_prefix2" class="materialize-textarea" name="resinterpela" maxlength="200"   data-length="200" minlength="10" pattern="[A-Za-z ]+" required ></textarea>
                          <label for="icon_prefix2">Dígite su respuesta al mensaje del estudiante.</label>
                        </div>
                        <div class="input-field s12 col center">
                          <button class="btn waves-effect waves-light bluetools white-text" type="submit" name="IDRI" value="<?php echo $RCVIDE['id_interpela'];?>">Enviar Respuesta
                            <i class="material-icons right">send</i>
                          </button>
                        </div>
                    </div> 
                    </form>
                    </div>
                      
                    </div>
                    <div class="modal-footer">
                      <a href="#!" class="modal-close waves-effect waves-green btn-flat redtools white-text">Cerrar</a>
                    </div>
                  </div>
                         
                    <br>     
                <?php         
                } 
            ?>    
                </div>
            </li>
        <?php
        } ?>
        </ul>
        <?php if($HayMensajes == 0)
        {
        ?>
        <div class="row">
        <div class="col s12 m6 offset-m6">
            <div class="chip hoverable z-depth-1 right greentools white-text chipsDerecha">
            <img src="../img/favicon.png" >
            <h5 class="black-text"> Aún no se ha enviado ningun mensaje</h5>
            </div>
            <div class="right-align">
            <input type="checkbox" checked="checked" disabled="disabled" />
            <span>Enviado: <b><?php echo strftime("%d-%B-%Y", strtotime($fecha)); ?></b></span>
            </div>
        </div>
        </div>
        
    <?PHP }

    ?>
    </div>
    </li> <br>
    <?php } ; ?>
    </ul>
<?php } ; ?>





<!-- *************** AGREGAR JS Y JQUERY **************-->
    <section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
   
    <script>
    $(document).ready(function(){
        $('.tabs').tabs();
        $('.tooltipped').tooltip();
        $('.modal').modal();
        $('select').formSelect();
        M.textareaAutoResize($('#icon_prefix2'));
        $('textarea#icon_prefix2').characterCounter();
        $(".dropdown-trigger").dropdown();
        $('.collapsible').collapsible();
        $('.datepicker').datepicker(
        {
            format: 'yyyy-mm-dd'            
        });
        
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });   
                
        $('#Menu_Buzon').addClass('red'); 
        $('#Menu_Buzon2').addClass('red'); 
        
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
        
    });
    </script>
</section>
<!-- *************** FIN DE AGREGAR JS Y JQUERY **************-->
</body>
</html>