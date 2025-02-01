<?php include('../log/cnxlo.php');?> 
<!--        ***************** VERIFICAR SI HAY SESION INICIADADA ***************-->
<section>
<?php  
    $MensajeAFIRMA = false;
    setlocale(LC_ALL,"es_ES");   
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
    
    $DocenteLogueado = $_SESSION['docente']; 
    $EsAdmin = $_SESSION['admin']; 
    
    
    if(isset($_GET['EADG']) && isset($_GET['iag']))
    {
        if($_GET['EADG'] == '099af53f601532dbd31e0ea99ffdeb64')
        {
            $EliminaAct =  "DELETE FROM actividad WHERE id_actividad = '".$_GET['iag']."'";
            mysqli_query($conex,$EliminaAct); 
            $MensajeAFIRMA = true;       
            header('Refresh: 2; URL=actividadesdoc.php');
        }
                
    }
     
    if(isset($_POST['AADG']))
    {
        //ID_ACTIVIDAD NameActG DescActG  FePaActG ModaActG LinkActG
        
        $ActualizaAct = "UPDATE actividad Set 
        actividad='".utf8_decode($_POST['NameActG'])."', 
        descripcion='".utf8_decode($_POST['DescActG'])."', 
        fechaplazo='".$_POST['FePaActG']."', 
        id_modalidad='".$_POST['ModaActG']."', 
        linkactividad='".utf8_decode($_POST['LinkActG'])."'

        WHERE id_actividad='".$_POST['ID_ACTIVIDAD']."'"; 

        mysqli_query($conex,$ActualizaAct); 
        $MensajeAFIRMA = true;       
        header('Refresh: 2; URL=actividadesdoc.php');
    }
    
    if(isset($_POST['FNACXG']))
    {
        //INSERTAR Id_TipoAcNA NameActNA  DescActNA FePaActNA ModaActNA LinkActNA
          mysqli_query($conex, 
            "INSERT INTO actividad             (actividad,descripcion,fechaplazo,id_tipoactividad,id_modalidad,linkactividad) 
            values 
          ('".utf8_decode($_POST['NameActNA'])."','".utf8_decode($_POST['DescActNA'])."','".$_POST['FePaActNA']."','".$_POST['Id_TipoAcNA']."','".$_POST['ModaActNA']."','".utf8_decode($_POST['LinkActNA'])."')");
        $MensajeAFIRMA = true;       
        header('Refresh: 2; URL=actividadesdoc.php');
    }
?>
</section>
<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Actividades | ToolsTIC v2.1</title> 
<!-- INCLUSION DEL HEADER --> 
<?php include ('../php/headmain.html');?>  
<link rel="shortcut icon" type="image/png" href="../img/favicon.png"/> 
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
        <li class="">
         
        <div class="collapsible-header"><i class="material-icons">assistant_photo</i><b>Grupo:</b> &nbsp; <b class="greentools-text"> <?php echo $arrayGruposDocente[$i][1]; ?> </b> <hr><b class="greentools-text">Aula : </b>&nbsp;<b><?php echo $arrayGruposDocente[$i][2]; ?></b></div>
          
        <div class="collapsible-body">
        <?PHP
        //CONSULTAR LOS TIPOS DE ACTIVIDADES 
        $TiAcGrupo = mysqli_query($conex,
            "SELECT * FROM tipoactividad, categoriaactividad 
            WHERE tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad 
            AND tipoactividad.id_grupo = '".$arrayGruposDocente[$i][0]."'"); ?>
        <ul class="collapsible">
        <?php 
        
        while($RCTAXG = mysqli_fetch_array($TiAcGrupo))
        {
            $CuantasActXC = 0;   
            $OpcionesEdicion = 0;
            $Id_TipoAct = $RCTAXG['id_tipoactividad'];
            $Id_Grupo = $RCTAXG['id_grupo'];
            $Porcentaje = $RCTAXG['porcentaje'];
            $Id_CateActi = $RCTAXG['id_categoriaActividad'];
            $CateActDetalle = utf8_encode($RCTAXG['categoriaActividad']);
            
            $CuentaActividades = mysqli_query($conex, 
                "SELECT * FROM actividad, tipoactividad, modalidad 
                WHERE  actividad.id_tipoactividad = tipoactividad.id_tipoactividad
                AND actividad.id_modalidad = modalidad.id_modalidad
                AND actividad.id_tipoactividad = '".$Id_TipoAct."'
                ");
            while($Rca = mysqli_fetch_array($CuentaActividades))
            {
                $CuantasActXC ++;                
                
            }
            
        ?>    
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i><b><?php  echo $CateActDetalle; ?></b> &nbsp;|&nbsp; <b class="greentools-text">No Actividades:</b>&nbsp;<b><?php echo $CuantasActXC; ?></b><hr><b class="greentools-text">Peso</b> &nbsp;<b><?php echo  $Porcentaje; ?>%</b></div>
         
            <div class="collapsible-body">
            <!-- INICIO DEL  collapsible body 4 opciones -->
            
            <ul id="tabs-swipe-demo" class="tabs bluetools white-text">
                <li class="tab col s3"><a class="white-text active" href="#test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+1;?>"><b>Listar Actividades</b></a></li>
                <li class="tab col s3"><a class="white-text" href="#test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+2; ?>"><b>Agregar Actividades</b></a></li>
                <li class="tab col s3"><a class="white-text" href="#test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+3; ?>"><b>Editar Actividades</b></a></li>
                <li class="tab col s3"><a class="white-text" href="#test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+4; ?>"><b>Eliminar Actividades</b></a></li>
                
            </ul>
            <!-- LISTAR ACTIVIDADES DEL GRUPO -->
            <div id="test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+1;?>" class="col s12 white">
            <?php
            $CuentaActividades2 = mysqli_query($conex, 
                "SELECT * FROM actividad, tipoactividad, modalidad 
                WHERE  actividad.id_tipoactividad = tipoactividad.id_tipoactividad
                AND actividad.id_modalidad = modalidad.id_modalidad
                AND actividad.id_tipoactividad = '".$Id_TipoAct."'
                ORDER BY actividad.fechaplazo DESC"); ?>
            
            
            
            <ul class="collapsible">
            
            
            <?php while($Rca2 = mysqli_fetch_array($CuentaActividades2))
            {                
                $RCId_actividad = $Rca2['id_actividad'];
                $RCactividad = utf8_encode($Rca2['actividad']);
                $RCdescripcion = utf8_encode($Rca2['descripcion']);
                $RCfechaplazo = $Rca2['fechaplazo'];
                $RCmodalidad = utf8_encode($Rca2['modalidad']);
                $RClink_actividad = $Rca2['linkactividad'];
            ?>   
            <li>
                <div class="collapsible-header"><i class="material-icons">exposure</i><b><?php echo htmlentities($RCactividad);?></b> &nbsp;
               </div>
                <div class="collapsible-body"> 
                
                <b class="greentools-text">Plazo de entrega: </b> &nbsp;<b><?php echo htmlentities(strftime("%A, %d de %B del %Y", strtotime($RCfechaplazo)));?></b> <br>
                
                <b class="greentools-text">Descripcion: </b> &nbsp;<b><?php echo htmlentities($RCdescripcion);?></b> <br>
                
                <b class="greentools-text">Modalidad: </b> &nbsp;<b><?php echo htmlentities($RCmodalidad);?></b> <br> <br>
                
                <a href="<?php echo $RClink_actividad;?>" target="_blank" class="btn bluetools white-text"><b>Ver actividad</b></a>
                
                </div>
            </li>   
            <?php    
            }
            ?>
            
            </ul>
            
            
            
            </div> <!-- FIN DE ACTIVIDADES DEL GRUPO -->
            
            <!-- AGREGAR ACTIVIDADES DEL GRUPO -->
            <div id="test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+2;?>" class="col s12 white">
            <div class="container">
            <br><br>
            <form class="col s12 align-center"  method="post" action="actividadesdoc.php">
            <div class="row">
                <input type="number" name="Id_TipoAcNA" value="<?php echo $Id_TipoAct; ?>" hidden>
                
                <div class="input-field col s12 m6 l4">
                <input placeholder="Nombre Actividad" id="NameActNA" type="text" class="validate" required name="NameActNA" maxlength="250">
                <label for="NameActNA" class="black-text"><b>Nombre Actividad</b></label>
                </div> 
                
                <div class="input-field col s12 m6 l4">
                <input placeholder="Descripción Actividad" id="DescActNA" type="text" class="validate" required name="DescActNA" maxlength="200">
                <label for="DescActNA" class="black-text"><b>Descripción Actividad</b></label>
                </div>
                
                <div class="input-field col s12 m6 l4">
                <input placeholder="Fecha Plazo" id="FePaActNA" type="text" class="validate datepicker" required name="FePaActNA">
                <label for="FePaActNA" class="black-text"><b>Fecha Plazo</b></label>
                </div>
                   
                <div class="input-field col s12 m6 l4">
                <select name="ModaActNA" id="ModaActNA" required> 
                  <option selected disabled >Seleccione</option>
                  <option value="1">Individual</option>
                  <option value="2">Binas</option>
                  <option value="3">Grupo</option>                
                </select>
                <label for="ModaActNA" class="black-text"><b>Modalidad Actividad</b></label>
                </div>
                     
                <div class="input-field col s12 m6 l4">
                <input placeholder="Link Actividad" required id="LinkActNA" type="text" name="LinkActNA">
                <label for="LinkActNA" class="black-text"><b>Link Actividad</b></label>
                </div>
                
                <div class="input-field col s12 m6 l4">
                    <button class="col s12 btn waves-effect waves-light bluetools white-text" type="submit" name="FNACXG" id="FNACXG">Agregar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
            </form>

            </div>
            </div>
            
            <!-- EDITAR ACTIVIDADES DEL GRUPO -->
            <div id="test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+3;?>" class="col s12 ">
            <?php
            $CuentaActividades2 = mysqli_query($conex, 
                "SELECT * FROM actividad, tipoactividad, modalidad 
                WHERE  actividad.id_tipoactividad = tipoactividad.id_tipoactividad
                AND actividad.id_modalidad = modalidad.id_modalidad
                AND actividad.id_tipoactividad = '".$Id_TipoAct."'
                ORDER BY actividad.fechaplazo DESC"); ?>
                               
            <ul class="collapsible "> 
            <?php while($Rca2 = mysqli_fetch_array($CuentaActividades2))
            {                
                $RCId_actividad = $Rca2['id_actividad'];
                $RCactividad = utf8_encode($Rca2['actividad']);
                $RCdescripcion = utf8_encode($Rca2['descripcion']);
                $RCfechaplazo = $Rca2['fechaplazo'];
                $RCmodalidad = utf8_encode($Rca2['modalidad']);
                $RCId_Modalidad = $Rca2['id_modalidad'];
                $RClink_actividad = $Rca2['linkactividad'];                
            ?>
            <li>
            <div class="collapsible-header greentools"><i class="material-icons">exposure</i><b><?php echo htmlentities($RCactividad);?></b> &nbsp;
            </div>
            <div class="collapsible-body white"> 
                <form class="col s12 align-center"  method="post" action="actividadesdoc.php">
                <div class="row">
                    <input type="number" name="ID_ACTIVIDAD" value="<?php echo $RCId_actividad; ?>" hidden>

                    <div class="input-field col s12 m6 l6">
                    <input placeholder="Nombre Actividad" id="NameActG" type="text" class="validate" value="<?php echo $RCactividad;?>" required name="NameActG">
                    <label for="NameActG" class="black-text"><b>Nombre Actividad</b></label>
                    </div> 

                    <div class="input-field col s12 m6 l6">
                    <input placeholder="Descripción Actividad" id="DescActG" type="text" class="validate" value="<?php echo $RCdescripcion;?>" required name="DescActG">
                    <label for="DescActG" class="black-text"><b>Descripción Actividad</b></label>
                    </div>

                    <div class="input-field col s12 m6 l6">
                    <input placeholder="Fecha Plazo" id="FePaActG" type="text" class="validate datepicker" required value="<?php echo $RCfechaplazo;?>" name="FePaActG">
                    <label for="FePaActG" class="black-text"><b>Fecha Plazo</b></label>
                    </div>

                    <div class="input-field col s12 m6 l6">
                    <select name="ModaActG" id="ModaActG" required> 
                     <?php if($RCId_Modalidad == 1) { ?>                            
                      <option value="1" selected>Individual</option>
                      <option value="2">Binas</option>
                      <option value="3">Grupo</option> 
                    <?php } elseif($RCId_Modalidad == 2){ ?>
                      <option value="1" >Individual</option>
                      <option value="2" selected>Binas</option>
                      <option value="3">Grupo</option> 
                    <?php } else { ?>
                      <option value="1" >Individual</option>
                      <option value="2" >Binas</option>
                      <option value="3" selected>Grupo</option> 
                    <?php } ?>
                    </select>
                    <label for="ModaActG" class="black-text"><b>Modalidad Actividad</b></label>
                    </div>

                    <div class="input-field col s12 m6 l6">
                    <input placeholder="Link Actividad" required id="LinkActG" type="text" value="<?php echo $RClink_actividad;?>" name="LinkActG">
                    <label for="LinkActG" class="black-text"><b>Link Actividad</b></label>
                    </div>

                    <div class="input-field col s12 m6 l6">
                        <button class="col s12 btn waves-effect waves-light bluetools white-text" type="submit" name="AADG" id="AADG">Actulizar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
                </form>
                 
            </div> 
            </li>  
            <?php    
            }
            ?> 
            </ul>                      
            </div>
            
            <!-- ELIMINAR ACTIVIDADES DEL GRUPO -->
            <div id="test-swipe-<?php echo $Id_Grupo.$Id_TipoAct.$OpcionesEdicion+4;?>" class="col s12 redtools">
            <br>
                <h6 class="black-text center container"><b>Para eliminar un actividad, no se solicita confirmación; por este motivo verifique muy bien la actividad que desea eliminar. esto eliminará támbien las notas de sus estudiantes.</b>
                <br> <br>
                </h6> <br>
            <?php
            $CuentaActividades2 = mysqli_query($conex, 
                "SELECT * FROM actividad, tipoactividad, modalidad 
                WHERE  actividad.id_tipoactividad = tipoactividad.id_tipoactividad
                AND actividad.id_modalidad = modalidad.id_modalidad
                AND actividad.id_tipoactividad = '".$Id_TipoAct."'
                ORDER BY actividad.fechaplazo DESC"); ?>
            
            <table class="centered highlight white container">
            <thead class="z-depth-3">
              <tr>                  
                  <th><b>Actividad</b></th>                  
                  <th><b>Fecha Plazo</b></th>
                  <th><b>Modalidad</b></th>
                  <th><b>Eliminar</b></th>
              </tr>
            </thead>

            <tbody>
            <?php while($Rca2 = mysqli_fetch_array($CuentaActividades2))
            {                
                $RCId_actividad = $Rca2['id_actividad'];
                $RCactividad = utf8_encode($Rca2['actividad']);
                $RCdescripcion = utf8_encode($Rca2['descripcion']);
                $RCfechaplazo = $Rca2['fechaplazo'];
                $RCmodalidad = utf8_encode($Rca2['modalidad']);
                $RClink_actividad = $Rca2['linkactividad'];
            ?>    
                <tr>
                    <td><?php echo $RCactividad;?></td>  
                    <td><?php echo $RCfechaplazo;?></td>                    
                    <td><?php echo $RCmodalidad;?></td>                    
                    <td><a href="actividadesdoc.php?EADG=099af53f601532dbd31e0ea99ffdeb64&iag=<?php echo $RCId_actividad;?>&delete=true" class="btn bluetools white-text redtools"><b>Eliminar</b></a></td>                    
                </tr>
              
            <?php    
            }
            ?>
            </tbody>
            </table>
            <br>
            </div>
            
            <!-- FIN collapsible body 4 opciones -->
            </div>
        </li>
        
        <?php } ?>
        </ul> 
        </div> <!-- FIN DEL DIV BODY LI-->
          
        </li> <br>    
    <?php }//FIN FOR DE LOS GRUPOS ?>
    </ul>
<?php } //FIN DEL ELSE SI HAY GRUPOS
?>


<!-- *************** AGREGAR JS Y JQUERY **************-->
    <section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
   
    <script>
    $(document).ready(function(){
        $('.tabs').tabs();
        $(".dropdown-trigger").dropdown();
        $('.collapsible').collapsible();
        $('select').formSelect();
        
        $('#Menu_Actividades').addClass('red'); 
        $('#Menu_Actividades2').addClass('red'); 
        
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
        
    // <!--        ***************** MENSAJE AFIRMA ***************-->
    <?php if ($MensajeAFIRMA == true ){ ?>        
        swal({
        title: "Correcto..!",
        text: "La acción fue registrada con exito..!",
        icon: "success",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $MensajeAFIRMA = false; }; ?>
    // <!--        ***************** FIN MENSAJE AFIRMA ***************-->
        
    });
    </script>
</section>
<!-- *************** FIN DE AGREGAR JS Y JQUERY **************-->
</body>
</html>