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

if(isset($_POST['FRNSAXG']))
{
    $Id_Activi = $_POST['id_activdad'];    
    $codigoe = $_POST['codigoe'];
    $IdEstadoAct = $_POST['estadoActividad'];  
    $Nota = $_POST['nota'];
    $FechaE = $_POST['Fecha'];
    $Retro = $_POST['retro'];
    
   
    for($i=0; $i<sizeof($codigoe); $i++)
    {
        $existeEstu = 0;
        
        $ConEstu = mysqli_query($conex,
            "SELECT * FROM notas 
            WHERE codigoe = '".$codigoe[$i]."'
            AND id_actividad = '".$Id_Activi[$i]."'");
        
        while($RCETN = mysqli_fetch_array($ConEstu))
        {
            $existeEstu ++;   
            //SE REALIZA UN UPDATE DE LA NOTA            
            //ACTUALIZAR 
            $ActualizaNota ="UPDATE notas Set 
            id_estadoactividad='".$IdEstadoAct[$i]."', 
            notaactividad='".$Nota[$i]."',
            fechaentrega='".$FechaE[$i]."',
            fechacalificada='".$fecha."', 
            retroalimentacion='".utf8_decode($Retro[$i])."'

            WHERE id_notas ='".$RCETN['id_notas']."'"; 

            mysqli_query($conex, $ActualizaNota);
            $MensajeAFIRMA = true;            
            header('Refresh: 2; URL=notasdoc.php');
        }
        
        if($existeEstu == 0)
        {
            // SE REGISTRA LA NOTA
            //INSERTAR
            mysqli_query($conex, 
            "INSERT INTO notas             (id_actividad,codigoe,id_estadoactividad,notaactividad,fechaentrega,fechacalificada,retroalimentacion) 
            values             ('".$Id_Activi[$i]."','".$codigoe[$i]."','".$IdEstadoAct[$i]."','".$Nota[$i]."','".$FechaE[$i]."','".$fecha."','".utf8_decode($Retro[$i])."')");
            $MensajeAFIRMA = true;            
            header('Refresh: 2; URL=notasdoc.php');
        }
        
        
    }
    
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/png" href="../img/favicon.png"/> 
<title>Notas Docente | ToolsTIC v2.1</title> 
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
         
        <div class="collapsible-header"><i class="material-icons">assistant_photo</i><b>Grupo:</b> &nbsp; <b class="greentools-text"> <?php echo $arrayGruposDocente[$i][1]; ?> </b><hr><b class="greentools-text">Aula : </b>&nbsp;<b><?php echo $arrayGruposDocente[$i][2]; ?></b></div>
          
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
                <div class="collapsible-header"><i class="material-icons">exposure
                </i><b><?php echo htmlentities($RCactividad);?></b> &nbsp;<b class="greentools-text">|| Plazo: </b> &nbsp;<b><?php echo $RCfechaplazo;?></b><hr><b class="greentools-text">Modalidad :</b>&nbsp; <b><td><?php echo $RCmodalidad;?></td></b></div>
                    
                <div class="collapsible-body white">                     
                    <b>Registro de Notas para </b> <b class="redtools-text"><?php echo htmlentities($RCactividad);?></b> &nbsp;<b> Estudiantes grupo: <?php echo $arrayGruposDocente[$i][1]; ?> </b><br><br>
                <div class="row">
                <form class="col s12 black-text" method="post" action="notasdoc.php">
                <?php
                    $ListarEstudainteGrupo = mysqli_query($conex,
                        "SELECT * FROM estudiante 
                        WHERE id_grupo = '".$arrayGruposDocente[$i][0]."'");
                
                while($RCLEXG = mysqli_fetch_array($ListarEstudainteGrupo))
                { 
                
                $LaNota = 0;
                $ElId = 6;
                $LaFecha ="";
                $LaRetro ="";
                    
                $TieneNota = mysqli_query($conex, 
                    "SELECT * FROM notas 
                    WHERE codigoe = '".$RCLEXG['codigoe']."'
                    AND id_actividad = '".$RCId_actividad."'");
                while($RTieneNota = mysqli_fetch_array($TieneNota)) 
                {
                    $LaNota = $RTieneNota['notaactividad'];
                    $ElId = $RTieneNota['id_estadoactividad'];
                    $LaFecha = $RTieneNota['fechaentrega'];
                    $LaRetro = $RTieneNota['retroalimentacion'];
                }
                    
                ?>     
                <div class="row black-text">
                
                <div class="input-field col s12 m6 l2">
                <input id="codi<?php $RCLEXG['codigoe']; ?>" type="text" class="validate black-text" value="<?php echo $RCLEXG['codigoe']; ?>" name="codigoe[]">
                <label for="codi<?php $RCLEXG['codigoe']; ?>" class="black-text"><b>Código</b></label>
                </div>
                
                <input type="text" name="id_activdad[]" value="<?php echo $RCId_actividad; ?>" hidden>
                
                <div class="input-field col s12 m6 l2">
                <input id="apellido<?php $RCLEXG['codigoe']; ?>" type="text" class="validate black-text" value="<?php echo $RCLEXG['nombre'].' '.utf8_encode($RCLEXG['apellido']); ?>">
                <label for="apellido<?php $RCLEXG['codigoe']; ?>" class="black-text"><b>Nombres</b></label>
                </div>
                
                <div class="input-field col s12 m6 l1">
                <input id="nota<?php $RCLEXG['codigoe']; ?>" type="number" step="any" class="validate black-text" min="0" max="5" name="nota[]" value="<?php echo $LaNota;?>">
                <label for="nota<?php $RCLEXG['codigoe']; ?>" class="black-text"><b>Nota</b></label>
                </div>
                
                <div class="input-field col s12 m6 l2">
                <input id="fecha" type="text" class="validate black-text datepicker" name="Fecha[]" value="<?php echo $LaFecha; ?>">
                <label for="fecha" class="black-text"><b>Entregada</b></label>
                </div>
                
                <div class="input-field col s12 m6 l3">
                <input id="retro<?php $RCLEXG['codigoe']; ?>" type="text" class="validate black-text" name="retro[]" value="<?php echo utf8_encode($LaRetro)?>" maxlength="200">
                <label for="retro<?php $RCLEXG['codigoe']; ?>" class="black-text"><b>Retroalimentación</b></label>
                </div>
                
                <div class="input-field col s12 m6 l2">
                    <select name="estadoActividad[]"> 
                        <?php 
                        if($ElId == 1) {
                            echo 
                          ' <option value="1" selected>No presentada</option>
                            <option value="2">Fuera de tiempo</option>
                            <option value="3">Presentada</option>
                            <option value="4">Falta Calificación</option>
                            <option value="5">Finalizada</option>
                            <option value="6">Pendiente</option> ';
                        }
                        else if ($ElId == 2){
                            echo 
                          ' <option value="1" >No presentada</option>
                            <option value="2" selected>Fuera de tiempo</option>
                            <option value="3">Presentada</option>
                            <option value="4">Falta Calificación</option>
                            <option value="5">Finalizada</option>
                            <option value="6">Pendiente</option> ';
                        }else if ($ElId == 3){
                            echo 
                          ' <option value="1" >No presentada</option>
                            <option value="2">Fuera de tiempo</option>
                            <option value="3" selected>Presentada</option>
                            <option value="4">Falta Calificación</option>
                            <option value="5">Finalizada</option>
                            <option value="6">Pendiente</option> ';
                        }else if ($ElId == 4){
                            echo 
                          ' <option value="1" >No presentada</option>
                            <option value="2">Fuera de tiempo</option>
                            <option value="3">Presentada</option>
                            <option value="4" selected>Falta Calificación</option>
                            <option value="5">Finalizada</option>
                            <option value="6">Pendiente</option> ';
                        }else if ($ElId == 5){
                            echo 
                          ' <option value="1" >No presentada</option>
                            <option value="2">Fuera de tiempo</option>
                            <option value="3">Presentada</option>
                            <option value="4">Falta Calificación</option>
                            <option value="5" selected >Finalizada</option>
                            <option value="6">Pendiente</option> ';
                        }
                        else{
                            echo 
                          ' <option value="1" selected>No presentada</option>
                            <option value="2">Fuera de tiempo</option>
                            <option value="3">Presentada</option>
                            <option value="4">Falta Calificación</option>
                            <option value="5">Finalizada</option>
                            <option value="6" selected>Pendiente</option> ';
                        }                      
                        ?>
                       </select>
                    <label><b>Estado</b></label>
                </div>

                
                
                </div>
                       
                <?php }
                ?> 
                <button class="btn waves-effect waves-light bluetools white-text col s12 m6 push-m3" type="submit" name="FRNSAXG">Registrar Notas
                    <i class="material-icons right">send</i>
                </button>
                </form>
                </div>           
                </div>             
                
            </li>   
            <?php    
            }
            ?>
            </ul>
            
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
        $('select').formSelect();
        $(".dropdown-trigger").dropdown();
        $('.collapsible').collapsible();
        $('#Menu_Notas').addClass('red'); 
        $('#Menu_Notas2').addClass('red'); 
        
        
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