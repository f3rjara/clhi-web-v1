<?PHP
 include('../log/cnxlo.php');

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
setlocale(LC_ALL,"es_CO");  
$hoy = getdate();
$fecha = $hoy['year']."-".$hoy['mon']."-".($hoy['mday']);

//<!--    *********** FIN VERIFICAR SI HAY SESION INICIADADA *********-->

$MensajeAFIRMA = false;  
$NoExistedocente = false; 
$YaExisteElEstu = false;
$YaExisteElDoce = false;
$EstudianteRegistrados = false;
$MensajeError = false;
$Clave = "a467de8eaf066d026030d1237020ce67";

//AGREGAR CATEGORIO ENVIOS DE FORMULARIO
if(isset($_POST['agregaTA']))
{
    //INSERTAR DATOS
    mysqli_query($conex, 
    "INSERT INTO tipoactividad 
    (id_grupo,porcentaje,id_categoriaActividad) 
    values    ('".$_POST['id_grupo']."','".$_POST['porcentaje']."','".$_POST['id_tipoActividad']."')");
    
    $MensajeAFIRMA = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=paneldoc.php');
}

if(isset($_POST['ATA']))
{   
    //ACTUALIZA LOS DATOS 
    //porcenFRM tipocateFRM  grupoFRM IdTipoActiviFRM   
    
    $_UPDATE_SQL=
    "UPDATE tipoactividad Set 
    id_grupo='".$_POST['grupoFRM']."', 
    porcentaje='".$_POST['porcenFRM']."', 
    id_categoriaActividad='".$_POST['tipocateFRM']."'    

    WHERE id_tipoactividad = '".$_POST['IdTipoActiviFRM']."'"; 

    mysqli_query($conex,$_UPDATE_SQL); 
    
    $MensajeAFIRMA = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=paneldoc.php');
    
}

if(isset($_GET['target']) && isset($_GET['ia']))
{
    if($_GET['target'] == "099af53f601532dbd31e0ea99ffdeb64")
    {
        //ELIMINAR
        $_DELETE_SQL =  "DELETE FROM tipoactividad WHERE id_tipoactividad = '".$_GET['ia']."'";
        mysqli_query($conex,$_DELETE_SQL); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
    
               
}

if(isset($_POST['FANG']))
{
    $DocentePost = $_POST['id_docenteG'];
    
    //EXISTE EL DOCENTE
    $TotalDoce = mysqli_query($conex,
        "SELECT * FROM docente 
        WHERE id_docente = '".$DocentePost."'");                    
    $existeDocente =  mysqli_num_rows($TotalDoce);
    
    if($existeDocente == 0)
    {
        $NoExistedocente = true;
        header('Refresh: 2; URL=paneldoc.php');
    }
    else
    {
        //INSERTAR
        mysqli_query($conex, 
            "INSERT INTO grupo 
        (detalle,year,periodo,aula,horainicio,horafin,id_docente) 
        values ('".$_POST['detalleG']."','".$_POST['añoG']."','".$_POST['periodoG']."','".$_POST['aulaG']."','".$_POST['horaInicioG']."','".$_POST['horaFinG']."','".$DocentePost."')");
        
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
}


if(isset($_POST['FEGA']))
{
    //ACTUALIZA LOS DATOS 
    //porcenFRM tipocateFRM  grupoFRM IdTipoActiviFRM   
    //Id_GrupoAC detalleAC añoAC periodoAC aulaAC horaInicioAC horaFinAC  id_docenteAC
    $ActualizaGrupo=
    "UPDATE grupo Set 
    id_grupo='".$_POST['Id_GrupoAC']."', 
    detalle='".$_POST['detalleAC']."', 
    year='".$_POST['añoAC']."', 
    periodo='".$_POST['periodoAC']."', 
    aula='".$_POST['aulaAC']."', 
    horainicio='".$_POST['horaInicioAC']."', 
    horafin='".$_POST['horaFinAC']."', 
    id_docente='".$_POST['id_docenteAC']."'    

    WHERE id_grupo = '".$_POST['Id_GrupoAC']."'"; 

    mysqli_query($conex,$ActualizaGrupo); 
    
    $MensajeAFIRMA = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=paneldoc.php');
}

if(isset($_GET['tardel']) && isset($_GET['ig']))
{
    if($_GET['tardel'] == "099af53f601532dbd31e0ea99ffdeb64")
    {
        //ELIMINAR
        $eliminaGrupo =  "DELETE FROM grupo WHERE id_grupo = '".$_GET['ig']."'";
        mysqli_query($conex,$eliminaGrupo); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
}

if(isset($_GET['deesgu']) && isset($_GET['ieg']))
{
    if($_GET['deesgu'] == "099af53f601532dbd31e0ea99ffdeb64")
    {
        //ELIMINAR ESTUDIANTE
        $eliminaEstudiante22 =  "DELETE FROM estudiante WHERE codigoe = '".$_GET['ieg']."'";
        mysqli_query($conex,$eliminaEstudiante22); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
}

if(isset($_POST['ETEDG']))
{
    $_POST['ETEDG'];
    
    //ELIMINAR
    $EliminaTEG =  "DELETE FROM estudiante WHERE id_grupo = '".$_POST['ETEDG']."'";
    mysqli_query($conex,$EliminaTEG); 
    
    $MensajeAFIRMA = true;        
    header('Refresh: 2; URL=paneldoc.php');
        
    
}

if(isset($_POST['FANEAG']))
{
    $ExisteElEstu = 0;
    // codigo_eNE nombre_eNE apellido_eNE  correo_eNE telefono_eNE  Grupo_eEE
    
    //CONSULTAR
    $BuscaEstu = mysqli_query($conex,
        "SELECT * FROM estudiante WHERE codigoe = '".$_POST['codigo_eNE']."'");
    while($RCEEE = mysqli_fetch_array($BuscaEstu))
    {
        $ExisteElEstu +=1;
    }
    
    if($ExisteElEstu == 0)
    {
        //INSERTAR DATOS
        mysqli_query($conex, 
        "INSERT INTO estudiante 
        (codigoe,nombre,apellido,correo,telefono,id_grupo) 
        values    ('".$_POST['codigo_eNE']."','".utf8_decode($_POST['nombre_eNE'])."','".utf8_decode($_POST['apellido_eNE'])."','".utf8_decode($_POST['correo_eNE'])."','".$_POST['telefono_eNE']."','".$_POST['Grupo_eEE']."')");

        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
    }
    else
    {
        $YaExisteElEstu = true;
    }
    
  
}

if(isset($_POST['FEPEL']))
{
    $archivo =$_FILES["archivo"]["name"];
    
    $archivo_rutaTemp = $_FILES["archivo"]["tmp_name"];
    
    $NameArchivoDocente = $DocenteLogueado.$archivo;
    
    function insertar_estudiantes($codigoe,$nombre,$apellido,$correo, $telefono, $id_grupo)
    {
        global $conex;
        
        $senenciaSQL = "INSERT INTO estudiante (codigoe, nombre, apellido, correo, telefono, id_grupo) VALUES ('".$codigoe."','".$nombre."','".$apellido."','".$correo."','".$telefono."','".$id_grupo."')";
        
        $ejecutar = mysqli_query($conex, $senenciaSQL);
        
        return $ejecutar;            
           
        
    }
    
    if(copy($archivo_rutaTemp, $NameArchivoDocente))
    {
        echo "<script> M.toast({html: 'El archivo se subio!', classes: 'rounded'}); </script>";  
    }
    else
    {
        $MensajeError = true;
        header('Refresh: 2; URL=paneldoc.php');
    }
    
    if(file_exists($NameArchivoDocente))
    {
        
    //CONSULTAR GRUPOS
    $arrayIdes = array();
    $IdesGrupos = mysqli_query($conex,"SELECT id_grupo FROM grupo WHERE id_docente = '".$DocenteLogueado."'");
    while($RSIDSG = mysqli_fetch_array($IdesGrupos))
    {
        $arrayIdes[] = $RSIDSG['id_grupo'];
    } // FIN WHILE
    
    
        
    $fp = fopen($NameArchivoDocente, "r");
    $TotalEstudiantes = -1;
        
    while($datos = fgetcsv($fp, 1000 ,";"))
    {        
        $TotalEstudiantes ++;
        if($TotalEstudiantes > 0)
        {  
            
            if (in_array($datos[5], $arrayIdes)) {  
                //CONSULTAR ESTUDIANTE
                $HayEstu = 0 ;

                $ExisESTU = mysqli_query($conex,"SELECT * FROM estudiante WHERE codigoe = '".$datos[0]."'");

                while($REXE = mysqli_fetch_array($ExisESTU))
                {
                    $HayEstu ++;
                }// FIN WHILE

                if($HayEstu == 0)  {
                    $ResFun = insertar_estudiantes($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5]);
                    $EstudianteRegistrados = true;        
                    //header('Refresh: 2; URL=paneldoc.php');  
                    
                    } // FIN SI NO EXISTE EL ESTUDIANTE

                else { 
                   echo "<script>alert('El estudiante: ".$datos[0]." no se registro. \\n\\nEl estudiante ya esta registrado en la plataforma');</script>"; 
                    } // FIN ELSE EL ESTU YA EXISTE
                
                } //FIN IF BUSCAR EN ARRAY
            
            else {
                //echo "No tiene ese grupo <br>";
                echo "<script>alert('El estudiante: ".$datos[0]." No se registro. \\n\\nEl id del Grupo no corresponde a ningúno de sus grupos asignados');</script>"; 
            } //FIN ELSE
            
        }// FIN IF TOTAL ESTUDANTES >0
        
    } // FIN WHILE
    
    } //FIN IF FILE_EXISTS
    
}//FIN ISSSET FEPEL

if(isset($_POST['FNNTT']))
{
    
    //INSERTAR NOTICIA
    mysqli_query($conex, 
        "INSERT INTO noticiastoolstic 
    (fecha,titulo,mensaje) 
    values 
    ('".$fecha."','".utf8_decode($_POST['TituNoti'])."','".utf8_decode($_POST['MensaNoti'])."')");
    
    $MensajeAFIRMA = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=paneldoc.php');
}

if(isset($_POST['FALNT']))
{
    //ACTUALIZAR 
    $_UPDATE_SQL="UPDATE noticiastoolstic Set     
    titulo='".utf8_decode($_POST['TituNotiAC'])."', 
    mensaje='".utf8_decode($_POST['MensaNotiAC'])."'

    WHERE id_noticia='".$_POST['IdNotiAC']."'"; 

    mysqli_query($conex,$_UPDATE_SQL); 
    $MensajeAFIRMA = true;
    //echo $correoEnviado.$telefonoEnviado."<hr>";
    header('Refresh: 2; URL=paneldoc.php');
}

if(isset($_GET['ento']) && isset($_GET['ni']))
{
    if($_GET['ento'] == "099af53f601532dbd31e0ea99ffdeb64")
    {
        //ELIMINAR
        $eliminaNoticia =  "DELETE FROM noticiastoolstic WHERE id_noticia = '".$_GET['ni']."'";
        mysqli_query($conex,$eliminaNoticia); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
}

if(isset($_POST['FADAP']))
{
    //Id_DocenteFR NomDocenteFR ApellDocenteFR CorreoDoceFR TeleDocenteFR     
    $EisteYaElDocente = 0;
    //CONSULTAR
    $ConDoceRegi = mysqli_query($conex,
        "SELECT * FROM docente WHERE id_docente = '".$_POST['Id_DocenteFR']."'");
    while($resdfr = mysqli_fetch_array($ConDoceRegi))
    {
        $EisteYaElDocente ++;        
    }
    
    if($EisteYaElDocente == 0){
        
        
    //INSERTAR DOCENTE
      mysqli_query($conex, "INSERT INTO docente 
      (id_docente,nombre, apellido,correo,telefono,clave) 
        values       ('".$_POST['Id_DocenteFR']."','".utf8_decode($_POST['NomDocenteFR'])."','".utf8_decode($_POST['ApellDocenteFR'])."','".$_POST['CorreoDoceFR']."','".$_POST['TeleDocenteFR']."','".$Clave."')");
        
        $MensajeAFIRMA = true;
        header('Refresh: 2; URL=paneldoc.php');
    }
    else
    {
        $YaExisteElDoce = true;
        header('Refresh: 2; URL=paneldoc.php');
    }
    
    
    
}

if(isset($_GET['eddp']) && isset($_GET['idd']))
{
    if($_GET['eddp'] == "099af53f601532dbd31e0ea99ffdeb64")
    {
        //ELIMINAR DOCENTE
        $EliminaDocente =  "DELETE FROM docente WHERE id_docente = '".$_GET['idd']."'";
        mysqli_query($conex,$EliminaDocente); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
        
    }
}

if(isset($_POST['FEDD']))
{
    //IdDocenAC Id_DocenteFAC NomDocenteFAC  ApellDocenteFAC  CorreoDoceFAC TeleDocenteFAC  ResetPWAC FEDD    
    if(isset($_POST['ResetPWAC'])){
        echo $Clave;
        //ACTUALIZAR LA CONTRASEÑA
        $ActualizaDocente ="UPDATE docente Set     
        id_docente='".$_POST['Id_DocenteFAC']."', 
        nombre='".utf8_decode($_POST['NomDocenteFAC'])."', 
        apellido='".utf8_decode($_POST['ApellDocenteFAC'])."', 
        correo='".utf8_decode($_POST['CorreoDoceFAC'])."', 
        telefono='".$_POST['TeleDocenteFAC']."',
        clave='".$Clave."'

        WHERE id_docente='".$_POST['IdDocenAC']."'"; 

        mysqli_query($conex,$ActualizaDocente); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        //header('Refresh: 2; URL=paneldoc.php');
    }
    else
    {
        //ACTUALIZAR LA CONTRASEÑA
        $ActualizaDocente ="UPDATE docente Set     
        id_docente='".$_POST['Id_DocenteFAC']."', 
        nombre='".utf8_decode($_POST['NomDocenteFAC'])."', 
        apellido='".utf8_decode($_POST['ApellDocenteFAC'])."', 
        correo='".utf8_decode($_POST['CorreoDoceFAC'])."', 
        telefono='".$_POST['TeleDocenteFAC']."'

        WHERE id_docente='".$_POST['IdDocenAC']."'"; 

        mysqli_query($conex,$ActualizaDocente); 
        $MensajeAFIRMA = true;
        //echo $correoEnviado.$telefonoEnviado."<hr>";
        header('Refresh: 2; URL=paneldoc.php');
    }
    
    
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Panel Control | ToolsTIC v2.1</title> 
<!-- INCLUSION DEL HEADER --> 
<?php include ('../php/headmain.html');
    include "../js/funciones.js";
    ?>  

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
$CuantosGruposXDocente = 0;

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
    
//CONSULTA DE GRUPOS DEL DOCENTE
$GruposDocente = mysqli_query($conex,
    "SELECT * FROM grupo, docente
    WHERE grupo.id_docente  = docente.id_docente 
    AND grupo.id_docente = '".$Id_Docente."'");

while($RCGXD = mysqli_fetch_array($GruposDocente))
{
    //($RCGXD['id_grupo'], $RCGXD['detalle'] , $RCGXD['id_docente'])
    $DetalleGruposDocente[] = array($RCGXD['id_grupo'], $RCGXD['detalle']);
}
    
if(isset($DetalleGruposDocente))
{
    $CuantosGruposXDocente = count($DetalleGruposDocente);  
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
 
<ul class="collapsible popout">
   <!--        ************* OPCION 1 CATEGORIAS Y PORCENTAJES ************-->
    <li>
        <div class="collapsible-header hoverable"><i class="material-icons">apps</i><b>Categorias | Tipos de Activiades por Grupo</b></div>
        <div class="collapsible-body">
            <?php 
            if($CuantosGruposXDocente == 0)
            {
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El docente no tiene grupos asignados</b></h5> <b> Comuniquese con el administrador del sitio para solicitar un grupo</b></div>';
            }
            else {
            ?>
            <!--        *************INICIO************-->  
            
            <ul id="tabs-swipe-demo" class="tabs bluetools">
                <li class="tab col s3 z-depth-5"><a href="#test-swipe-0" class="white-text"><b>Listar Categorias</b></a></li>
                <li class="tab col s3"><a href="#test-swipe-1" class="white-text"><b>Agregar Categoria</b></a></li>
                <li class="tab col s3 z-depth-5"><a href="#test-swipe-2" class="white-text"><b>Editar Categoria</b></a></li>
                <li class="tab col s3"><a href="#test-swipe-3" class="white-text"><b>Eliminar Categoria</b></a></li>
            </ul>
            
            <!--        *************LISTAR CATEGORUAS ************-->  
            <div id="test-swipe-0" class="col s12 white">
            <ul class="collapsible">            
            <?php 
            for($i=0; $i <= $CuantosGruposXDocente-1; $i++)
            {
            ?>
            <li>
              <div class="collapsible-header"><i class="material-icons">assistant_photo</i> <b>Grupo: <?php echo $DetalleGruposDocente[$i][1] ?></b></div>
                <div class="collapsible-body">
                  <span> 
                    <?php
                    $HayCategoria=0;              
                    //SUB CONSULTA DE TIPOS DE ACTIVIDADES POR GRUPO
                    $CategoriaGrupo = mysqli_query($conex,
                    "SELECT * FROM categoriaactividad, tipoactividad, grupo 
                    WHERE tipoactividad.id_grupo = grupo.id_grupo
                    AND tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad
                    AND tipoactividad.id_grupo = '".$DetalleGruposDocente[$i][0]."'
                    ");
                    ?>
                    <table class="highlight centered">
                    <thead>
                      <tr>
                          <th><b>No</b></th>
                          <th><b>Grupo</b></th>
                          <th><b>Tipo Actividad</b></th>
                          <th><b>Peso</b></th>
                      </tr>
                    </thead
                    <tbody>
                   <?php
                    while($RCCXG = mysqli_fetch_array($CategoriaGrupo))
                    {
                        $HayCategoria ++;
                        $detalleGrupo = $RCCXG['detalle'];
                        $categoriaActividad = $RCCXG['categoriaActividad'];
                        $porcentaje = $RCCXG['porcentaje'];
                    ?>   
                        <tr>
                            <td><?php echo $HayCategoria; ?></td>
                            <td><?php echo $detalleGrupo; ?></td>
                            <td><?php echo utf8_encode($categoriaActividad); ?></td>
                            <td><?php echo $porcentaje; ?>%</td>
                        </tr>
                    <?php                         
                    }
                    ?>
                    </tbody>
                    </table>
                   <?php
                    if ($HayCategoria == 0)
                    {
                        echo '<br><div class="center"><span><b>Total de Categorias del grupo:</b> &nbsp;&nbsp; <b>'.$HayCategoria.'</b></span></div> <hr>';
                    }
                    ?>                  
                  </span>
                </div>
            </li>            
            <?php }; ?>
            </ul>
            
            
            </div>
            
            <!--        *************AGREGAR CATEGORIAS************-->  
            <div id="test-swipe-1" class="col s12 greentools">
               <br>
                <h6 class="black-text center container"><b>Para agregar un tipo de actividad a un grupo específico, tenga en cuenta que el peso debe ser correspondiente al grupo, es decir este no debe superar el 100% entre todos los tipos de actividades por grupo; esto con el fin al momento de calcular las notas no se presenten inconvenientes.</b>
                <br> <br>
                    
                </h6> <br>
                <center>
                <h5 class="white  align-center">
                <br>    
                <div class="row container">
                
    <form class="col s12  black-text" method="post" action="paneldoc.php" enctype="multipart/form-data">
        <div class="row">
        <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Seleccione el grupo" >
            <select name="id_grupo" class="validate " required>
              <option value=""  disabled selected>Seleccione el grupo</option>
                <?php
                for($i=0; $i <= $CuantosGruposXDocente -1; $i++)
                {
                    echo '<option  value="'.$DetalleGruposDocente[$i][0].'"><b>Grupo '.$DetalleGruposDocente[$i][1].'</b></option>';
                }
               
                ?>    
            </select>
            <label>Grupo</label>
        </div>
              
        <div class="input-field col s12 m6 tooltipped red-text" data-position="bottom" data-tooltip="Seleccione la categoria">           
            <select name="id_tipoActividad" class="validate" required>
              <option value="" disabled selected>Seleccione el tipo</option>
              <?php
            $CategoriasActivas = mysqli_query($conex,
                "SELECT * FROM categoriaactividad");
            while($RCCA2 = mysqli_fetch_array($CategoriasActivas))
            {
                $IdActividad = $RCCA2['id_categoriaActividad'];
                $CategoriaActividad = $RCCA2['categoriaActividad'];
                $DetalleActividad = $RCCA2['detallecateactividad'];
                
                echo '<option value="'.$IdActividad.'">'.utf8_encode($CategoriaActividad).'  </option>';
            }
            ?>
            </select>
            <label>Tipo de Actividad</label>
            
        </div>
        
        <div class="input-field col s12 m">
          <input id="porcentaje" name="porcentaje" type="number" min="0" max="100" class="validate black-text" required>
          <label for="porcentaje">Porcentaje</label>
        </div>
        
        <div class="input-field col s12 m6">
             <button class="btn waves-effect waves-light col s12 bluetools white-text" type="submit" name="agregaTA"><b>Agregar Categoria al Grupo</b>
            <i class="material-icons right">send</i>
              </button>
        </div>
        <label class="red-text">** Todos los campos son Obligatorios </label>
        </div>
        
    </form>  
                </div> 
                
                </h5></center>
                <center class="container">
                <b>Tipos de Actividades:</b> <br>(Pase el mouse sobre los botones para conocer más) <br> <br>
                <?php
                $CategoriasActivas = mysqli_query($conex,
                "SELECT * FROM categoriaactividad");
                echo '<div class="row">';
            while($RCCA = mysqli_fetch_array($CategoriasActivas))
            {
                $IdActividad = $RCCA['id_categoriaActividad'];
                $CategoriaActividad = $RCCA['categoriaActividad'];
                $DetalleActividad = $RCCA['detallecateactividad'];
                
                echo '<div class="col s12 m3">
                <a class="btn tooltipped bluetools col s12" data-position="top" 
                data-tooltip="<b>'.utf8_encode($CategoriaActividad).' </b>: '.utf8_encode($DetalleActividad).'">'.utf8_encode($CategoriaActividad).'</a> &nbsp;</div>';
            }
               echo "</div>";
               ?>
                
                 </center>
            </div>  
             
            <!--        *************EDITAR CATEGORIAS************-->  
            <div id="test-swipe-2" class="col s12 white">
            <ul class="collapsible">            
            <?php 
            for($i=0; $i <= $CuantosGruposXDocente-1; $i++)
            {
            ?>
            <li>
              <div class="collapsible-header black-text"><i class="material-icons">assistant_photo</i> <b>Grupo: <?php echo $DetalleGruposDocente[$i][1] ?></b></div>
                <div class="collapsible-body">
                  <span> 
                    <?php
                    $HayCategoria=0;              
                    //SUB CONSULTA DE TIPOS DE ACTIVIDADES POR GRUPO
                    $CategoriaGrupo = mysqli_query($conex,
                    "SELECT * FROM categoriaactividad, tipoactividad, grupo 
                    WHERE tipoactividad.id_grupo = grupo.id_grupo
                    AND tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad
                    AND tipoactividad.id_grupo = '".$DetalleGruposDocente[$i][0]."'
                    ");
                    ?>
                    <table class="highlight centered">
                    <thead class="black-text">
                      <tr class="blue">
                          <th><b>No</b></th>
                          <th><b>Grupo</b></th>
                          <th><b>Tipo Actividad</b></th>
                          <th><b>Peso</b></th>
                          <th><b>Actualizar</b></th>
                      </tr>
                    </thead>
                    </table>
                    
                   <?php
                    while($RCCXG = mysqli_fetch_array($CategoriaGrupo))
                    {
                        $HayCategoria ++;
                        $IdGrupoCons = $RCCXG['id_grupo'];
                        $Id_TipoActividad = $RCCXG['id_tipoactividad'];
                        $detalleGrupo = $RCCXG['detalle'];
                        $Id_CategoriaActividad = $RCCXG['id_categoriaActividad'];
                        $categoriaActividad = utf8_encode($RCCXG['categoriaActividad']);
                        $porcentaje = $RCCXG['porcentaje'];    
                        //<td><?php echo $Id_TipoActividad; </td>
                    ?>   
                    
                        <form class="col s12" method="post" action="paneldoc.php"> 
                        <div class="row center">
                        
                        <input type="number" value="<?php echo $Id_TipoActividad;?>" name="IdTipoActiviFRM" hidden> 
                            
                        <div class="input-field col s12 m1 l1">                  
                        <?php echo $HayCategoria; ?> 
                        </div>
                        
                        <div class="input-field col s12 m5 l3">                          
                        <select name="grupoFRM"  id="grupo">
                        <?php
                          //CONSULTAR GRUPOS
                        
                            $GruposDocente2 = mysqli_query($conex,
                            "SELECT * FROM grupo, docente 
                            WHERE grupo.id_docente = docente.id_docente
                            AND docente.id_docente = '".$_SESSION['docente']."'" ); 
                            
                            while($RCGD2 = mysqli_fetch_array($GruposDocente2)) {
                            $id_Grupo =$RCGD2['id_grupo'];
                            $detalleGrupo2 = $RCGD2['detalle'];
                                
                            //echo '<script>alert('.$id_Grupo.')</script>'; 
                            if($id_Grupo == $DetalleGruposDocente[$i][0] ) {
                            ?> <option class="black-text" value="<?php echo $id_Grupo; ?>" selected><?php echo $detalleGrupo2; ?></option> <?PHP
                            }
                            else {
                            ?> <option class="black-text" value="<?php echo $id_Grupo; ?>" ><?php echo $detalleGrupo2; ?></option> <?PHP
                            }    
                            }
                        ?>    
                        </select>
                        <label for="grupo">Grupos activos</label>
                        </div>
                         
                        <div class="input-field col s12 m6 l3">
                        <select id="tipoac" class="center" name="tipocateFRM" required>

                        <?php
                        //CONSULTAR
                        $CategoriasActividad = mysqli_query($conex,
                        "SELECT * FROM categoriaactividad" ); 
                        while($RCCA2 = mysqli_fetch_array($CategoriasActividad))
                        {
                        $id_categoriaActividad2 =$RCCA2['id_categoriaActividad'];
                        $CategoriaActividad =$RCCA2['categoriaActividad'];

                        if($id_categoriaActividad2 == $Id_CategoriaActividad ){
                        ?> <option class="black-text" selected value="<?php echo $id_categoriaActividad2 ?> "> <?php echo utf8_encode($CategoriaActividad); ?> </option>
                        <?php }
                        else{ ?>
                        <option class="black-text" value="<?php echo $id_categoriaActividad2 ?> "> <?php echo utf8_encode($CategoriaActividad); ?> </option>
                        <?php }       
                        }
                        ?>

                        </select>
                        <label for="tipoac" >Seleccione Tipo Actividad</label>
                        </div>
                       
                       
                        
                        <div class="input-field col s12 m6 l3">
                          <input id="porcen" type="number" name="porcenFRM" value="<?php echo $porcentaje; ?>" min="0" max="100" required class="validate">
                          <label for="porcen">Peso Actividad</label>
                        </div>                        
                        
                        <div class="input-field col s12 m6 l2">
                            <button class="btn waves-effect waves-light bluetools white-text" type="submit" name="ATA" value="ATA">Actualizar
                            <i class="material-icons right">send</i>
                          </button>
                        </div> 
                        </div>    
                        </form>                        
                    </tr>
                    <?php                         
                    }
                    ?>
                    
                   <?php
                    if ($HayCategoria == 0)
                    {
                        echo '<br><div class="center"><span><b>Total de Categorias del grupo:</b> &nbsp;&nbsp; <b>'.$HayCategoria.'</b></span></div> <hr>';
                    }
                    ?>                  
                  </span>
                </div>
            </li>            
            <?php }; ?>
            </ul>
            
            </div>
            
            <!--        *************ELIMINAR CATEGORIAS************-->  
            <div id="test-swipe-3" class="col s12 redtools">
            <br>
            <h6 class="black-text center container"><b>La eliminación de las categorias de grupos no requiere confirmación. por este motivo verifique muy bien sus acciones a la hora de eliminar una categoria.</b>
            <br> <br>

            </h6> <br>
                
             <ul class="collapsible white">            
            <?php 
            for($i=0; $i <= $CuantosGruposXDocente-1; $i++)
            {
            ?>
            <li>
              <div class="collapsible-header"><i class="material-icons">assistant_photo</i> <b>Grupo: <?php echo $DetalleGruposDocente[$i][1] ?></b></div>
                <div class="collapsible-body">
                  <span> 
                    <?php
                    $HayCategoria=0;              
                    //SUB CONSULTA DE TIPOS DE ACTIVIDADES POR GRUPO
                    $CategoriaGrupo = mysqli_query($conex,
                    "SELECT * FROM categoriaactividad, tipoactividad, grupo 
                    WHERE tipoactividad.id_grupo = grupo.id_grupo
                    AND tipoactividad.id_categoriaActividad = categoriaactividad.id_categoriaActividad
                    AND tipoactividad.id_grupo = '".$DetalleGruposDocente[$i][0]."'
                    ");
                    ?>
                    <table class="highlight centered">
                    <thead class="redtools">
                      <tr>
                          <th><b>No</b></th>
                          <th><b>Grupo</b></th>
                          <th><b>Tipo Actividad</b></th>
                          <th><b>Peso</b></th>
                          <th><b>Eliminar Categoria</b></th>
                      </tr>
                    </thead
                    <tbody>
                   <?php
                    while($RCCXG = mysqli_fetch_array($CategoriaGrupo))
                    {
                        $HayCategoria ++;
                        $Id_TipoActividad = $RCCXG['id_tipoactividad'];
                        $detalleGrupo = $RCCXG['detalle'];
                        $categoriaActividad = $RCCXG['categoriaActividad'];
                        $porcentaje = $RCCXG['porcentaje'];
                    ?>   
                        <tr>
                            <td><?php echo $HayCategoria; ?></td>
                            <td><?php echo $detalleGrupo; ?></td>
                            <td><?php echo utf8_encode($categoriaActividad); ?></td>
                            <td><?php echo $porcentaje; ?>%</td>
                            <td><a href="paneldoc.php?target=099af53f601532dbd31e0ea99ffdeb64&ia=<?php echo $Id_TipoActividad;?>&delete=true" class="btn col s12 red white-text ">Eliminar </a> </td>
                        </tr>
                    <?php                         
                    }
                    ?>
                    </tbody>
                    </table>
                   <?php
                    if ($HayCategoria == 0)
                    {
                        echo '<br><div class="center"><span><b>Total de Categorias del grupo:</b> &nbsp;&nbsp; <b>'.$HayCategoria.'</b></span></div> <hr>';
                    }
                    ?>                  
                  </span>
                </div>
            </li>            
            <?php }; ?>
            </ul>
                
                
            </div>
            <!--        *************FIN************--> 
            <?php }; // FIN DEL IF $CuantosGruposXDocente ?> 
        </div>
    </li>
   <!--        ************* FIN DE OPCION 1 CATEGORIAS Y PORCENTAJES ************--> 
    
   <!--        ************* OPCION 2 GRUPOS  ************-->  
    <br>
    <li>
      <div class="collapsible-header hoverable"><i class="material-icons">group</i><b>Mis Grupos</b></div>    
        <div class="collapsible-body">
           <?php 
            if($CuantosGruposXDocente == 0)
            {
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El docente no tiene grupos asignados</b></h5> <b> Comuniquese con el administrador del sitio para solicitar un grupo</b></div>';
            }
            else {
            ?>            
            <!--        *************INICIO************-->  
            <ul id="tabs-swipe-demo" class="tabs bluetools">
                <li class="tab col s3 z-depth-5 active"><a href="#grupos-0" class="white-text"><b>Listar Grupos</b></a></li> 
                <?php
                if($EsAdmin == "true")
                { ?>
                    <li class="tab col s3 z-depth-5 active"><a href="#grupos-1" class="white-text"><b>Agregar Grupos</b></a></li>
                    
                    <li class="tab col s3 z-depth-5 active"><a href="#grupos-2" class="white-text"><b>Editar Grupos</b></a></li> 
                    
                    <li class="tab col s3 z-depth-5 active"><a href="#grupos-3" class="white-text"><b>Eliminar Grupos</b></a></li>  
                <?php }
                ?>
            </ul>
            
            <!--        *************LISTAR GRUPOS ************-->  
            <div id="grupos-0" class="col s12 white">
            <ul class="collapsible">
            <?php   
                //------------------------------------------------
                //CONSULTAR GRUPOS ACTIVOS DEL DOCENTE
                $GruposActivosDocente = mysqli_query($conex,
                    "SELECT * FROM grupo 
                    WHERE id_docente = '".$DocenteLogueado."'");
                while($RCGAD = mysqli_fetch_array($GruposActivosDocente))
                {
                    $idGrupoG = $RCGAD['id_grupo'];
                    $detalleG = $RCGAD['detalle'];
                    $yearG = $RCGAD['year'];
                    $periodoG = $RCGAD['periodo'];
                    $aulaG = $RCGAD['aula'];
                    $horainicioG = $RCGAD['horainicio'];
                    $horafinG = $RCGAD['horafin'];
                    
                     //CONSULTAR TOTAL ESTUDIANTES POR GRUPO
                    $TotalEsGru = mysqli_query($conex,
                        "SELECT * FROM grupo,estudiante 
                        WHERE grupo.id_grupo = estudiante.id_grupo
                        AND estudiante.id_grupo = '".$idGrupoG."'");                    
                    $TotalesEstu =  mysqli_num_rows($TotalEsGru);
                ?>
    <li>
        <div class="collapsible-header"><i class="material-icons">assistant_photo</i>
        <b>Grupo: <?php echo $detalleG ?></b></div>
        <div class="collapsible-body">
        <table class="centered highlight">
        <thead>
          <tr>
              <th>Grupo</th>
              <th>Periodo</th>
              <th>Aula</th>
              <th>Hora Inicio</th>
              <th>Hora Fin</th>
              <th>Cantidad Estudiantes</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td><?php echo $detalleG; ?></td>
            <td><?php echo $periodoG." - ".$yearG; ?></td>
            <td><?php echo $aulaG; ?></td>
            <td><?php echo $horainicioG; ?></td>
            <td><?php echo $horafinG; ?></td>
            <td><?php echo $TotalesEstu; ?></td>            
          </tr>          
        </tbody>
      </table>
    
        </div>
    </li>
    <?php  }  ?> 
            </ul>   
            </div> 
            
            <?php if($EsAdmin == "true") { ?>
            <!--        *************AGREGAR GRUPOS ************-->  
            <div class="col s12 greentools" id="grupos-1">
                <br>
                <h6 class="black-text center container"><b>Para agregar un nuevo grupo es necesario que el docente ya este registrado en la plataforma. Si aún no está registrado, por favor agregue al docente como nuevo usuario.</b>
                <br> <br>
                </h6> <br>
                
                <h5 class="white  align-center">
                <center>
                <div class="row container align-center"> <br>
                    <form class="col s12" method="post" action="paneldoc.php">
                      <div class="row">
                       
                        <div class="input-field col s12 m6">
                          <input placeholder="G99" id="detalle" type="text" class="validate tooltipped uppercase " name="detalleG" data-position="botton" data-tooltip="El nombre del grupo debe ser simple. por ejemplo G99" required>
                          <label for="detalle">Nombre del Grupo</label>
                        </div>
                        
                        <div class="input-field col s6 m3">
                          <input placeholder="2000" id="añoG" type="text" class="validate tooltipped" name="añoG"  required pattern="[0-9]{4}" data-position="botton" data-tooltip="El año activo para el curso" required>
                          <label for="añoG">Año</label>
                        </div>
                        
                        <div class="input-field col s6 m3">
                          <select name="periodoG" id="periodoG" required>
                              <option value="" disabled selected>Seleccione</option>
                              <option value="A">Semestre A</option>                         
                              <option value="B">Semestre B</option>                         
                            </select>
                            <label for="periodoG">Seleccione periodo</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="401" id="aulaG" type="text" class="validate tooltipped" name="aulaG"  required pattern="[0-9]{3}" data-position="botton" data-tooltip="El aula en el que se dictará" required>
                          <label for="aulaG">Aula</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="08:00:00" id="horaInicioG" type="text" class="validate tooltipped" name="horaInicioG"  required pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" data-position="botton" data-tooltip="La hora de inico del curso" required>
                          <label for="horaInicioG">Hora Inicio</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="08:00:00" id="horaFinG" type="text" class="validate tooltipped" name="horaFinG"  required pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" data-position="botton" data-tooltip="La hora de fin del curso" required>
                          <label for="horaFinG">Hora Fin</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                          <input placeholder="1085123123" id="id_docenteG" type="number" class="validate tooltipped" name="id_docenteG" data-position="botton" data-tooltip="Cedula del docente para el grupo" required>
                          <label for="id_docenteG">Cedula del docente</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                          <button class="btn waves-effect waves-light col s12 bluetools white-text" type="submit" name="FANG" value="FANG">Agregar Grupo
                            <i class="material-icons right">send</i>
                          </button>
                        </div>
                        
                      </div> 
                    </form>
                <br><br></div>
                </center>
                
                </h5>
            </div>
            
            <!--        *************EDITAR TODOS LOS GRUPOS ************-->  
            <div class="col s12" id="grupos-2">
                <ul class="collapsible">
            <?PHP
            //CONSULTAR TODOS LOS GRUPOS
            $GruposActivos = mysqli_query($conex,
                "SELECT * FROM grupo,docente 
                WHERE grupo.id_docente = docente.id_docente
                ORDER BY grupo.id_docente, grupo.aula ASC");
            while($RCGA3 = mysqli_fetch_array($GruposActivos))
            {
                $idDocenteAC = $RCGA3['id_docente'];
                $nombreDocenteAC = $RCGA3['nombre'];
                $apellidoDocenteAC = $RCGA3['apellido'];
            
                $IdGrupoAC = $RCGA3['id_grupo'];
                $detalleGrupoAC = $RCGA3['detalle'];
                $yearGrupoAC = $RCGA3['year'];
                $periodoGrupoAC = $RCGA3['periodo'];
                $aulaGrupoAC = $RCGA3['aula'];
                $horaInicioAC = $RCGA3['horainicio'];
                $horaFinAC = $RCGA3['horafin'];
                
                
            ?> 
            <li>
                <div class="collapsible-header"><i class="material-icons">assistant_photo</i> <b>Grupo: <?php echo $detalleGrupoAC ?></b><hr><b><b class="greentools-text">Docente</b> | <?php echo $nombreDocenteAC." ".$apellidoDocenteAC; ?> </b></div>
                
                <div class="collapsible-body white">
                <center>
                <div class="row container align-center"> <br>
                    <form class="col s12" method="post" action="paneldoc.php">
                      <div class="row">
                       
                        <input type="number" name="Id_GrupoAC" hidden value="<?php echo $IdGrupoAC;?>">
                        
                        <div class="input-field col s12 m6">
                          <input placeholder="G99" id="detalleAC" type="text" class="validate tooltipped uppercase " name="detalleAC" data-position="botton" data-tooltip="El nombre del grupo debe ser simple. por ejemplo G99" required value="<?php echo $detalleGrupoAC;?>">
                          <label for="detalleAC">Nombre del Grupo</label>
                        </div>
                        
                        <div class="input-field col s6 m3">
                          <input placeholder="2000" id="añoAC" type="text" class="validate tooltipped" name="añoAC"  required pattern="[0-9]{4}" data-position="botton" data-tooltip="El año activo para el curso" required value="<?php echo $yearGrupoAC;?>">
                          <label for="añoAC">Año</label>
                        </div>
                        
                        <div class="input-field col s6 m3">
                          <select name="periodoAC" id="periodoAC" required>
                              <?php
                                if($periodoGrupoAC == "A"){ ?>
                              <option value="A" selected>Semestre A</option>
                              <option value="B" >Semestre B</option> <?php } else { ?>        
                              <option value="A" >Semestre A</option>                
                              <option value="B" selected>Semestre B</option>  <?php }; ?>                       
                            </select>
                            <label for="periodoAC">Seleccione periodo</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="401" id="aulaAC" type="text" class="validate tooltipped" name="aulaAC"  required pattern="[0-9]{3}" data-position="botton" data-tooltip="El aula en el que se dictará" required value="<?php echo $aulaGrupoAC;?>">
                          <label for="aulaAC">Aula</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="08:00:00" id="horaInicioAC" type="text" class="validate tooltipped" name="horaInicioAC"  required pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" data-position="botton" data-tooltip="La hora de inico del curso" required value="<?php echo $horaInicioAC;?>">
                          <label for="horaInicioAC">Hora Inicio</label>
                        </div>
                        
                        <div class="input-field col s6 m4">
                          <input placeholder="08:00:00" id="horaFinAC" type="text" class="validate tooltipped" name="horaFinAC"  required pattern="(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}" data-position="botton" data-tooltip="La hora de fin del curso" required value="<?php echo $horaFinAC;?>">
                          <label for="horaFinAC">Hora Fin</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                          <input placeholder="1085123123" id="id_docenteAC" type="number" class="validate tooltipped" name="id_docenteAC" data-position="botton" data-tooltip="Cedula del docente para el grupo" required value="<?php echo $idDocenteAC;?>">
                          <label for="id_docenteAC">Cedula del Docente</label>
                        </div>
                        
                        <div class="input-field col s12 m6">
                          <button class="btn waves-effect waves-light col s12 greentools white-text" type="submit" name="FEGA" value="FEGA">Actualizar Grupo
                            <i class="material-icons right">send</i>
                          </button>
                        </div>
                        
                      </div> 
                    </form>
                <br><br></div>
                </center>
                
                
                </div>
            </li>
            
            
            <?php }                             
            ?>    
                </ul>                
            </div>
            
            <!--        *************ELIMINAR  GRUPOS ************-->  
            <div class="col s12 redtools" id="grupos-3">
                <br>
                <h6 class="black-text center container"><b>Para eliminar un grupo, no se solicita confirmación; por este motivo verifique muy bien el grupo al cual desea eliminar. esto eliminará támbien sus estudiantes y actividades que tenga el grupo, asi mismo, al docente a cargo del grupo.</b>
                <br> <br>
                </h6> <br>
                
                <h5 class="white  align-center">
                <center>
                <div class="row white container"> <br>
                    
                <table class="highlight centered">
                <thead>
                  <tr>
                      <th>Grupo</th>
                      <th>Aula</th>
                      <th>Docente</th>
                      <th>Periodo</th>
                      <th>Eliminar</th>
                  </tr>
                </thead>

                <tbody>
                <?PHP
                //CONSULTAR TODOS LOS GRUPOS
                $GruposActivos = mysqli_query($conex,
                    "SELECT * FROM grupo,docente 
                    WHERE grupo.id_docente = docente.id_docente
                    ORDER BY grupo.id_docente, grupo.aula ASC");
                while($RCGA3 = mysqli_fetch_array($GruposActivos))
                {
                    $idDocenteAC = $RCGA3['id_docente'];
                    $nombreDocenteAC = $RCGA3['nombre'];
                    $apellidoDocenteAC = $RCGA3['apellido'];

                    $IdGrupoAC = $RCGA3['id_grupo'];
                    $detalleGrupoAC = $RCGA3['detalle'];
                    $yearGrupoAC = $RCGA3['year'];
                    $periodoGrupoAC = $RCGA3['periodo'];
                    $aulaGrupoAC = $RCGA3['aula'];
                    $horaInicioAC = $RCGA3['horainicio'];
                    $horaFinAC = $RCGA3['horafin'];
                ?>        
                <tr>
                    <td><?php echo $detalleGrupoAC; ?></td>
                    <td><?php echo $aulaGrupoAC; ?></td>
                    <td><?php echo $nombreDocenteAC." ".$apellidoDocenteAC; ?></td>
                    <td><?php echo $periodoGrupoAC."-".$yearGrupoAC; ?></td>
                    <td><a href="paneldoc.php?tardel=099af53f601532dbd31e0ea99ffdeb64&ig=<?php echo $IdGrupoAC; ?>&delete=true" class="btn redtools back-text"> <b>Eliminar Grupo</b></a></td>                    
                </tr>
                <?php }?> 
                </tbody>
                </table> 
                <br><br></div>
                </center>
                </h5>
            </div>
            
            <!--        *************FIN************-->            
            <?php }; // FIN SI EL DOCENTE ES ADMIN ?>
            <?php }; // FIN DEL IF $CuantosGruposXDocente ?> 
        </div>
    </li>
    <!--        ************* FIN DE OPCION 2 GRUPOS  ************-->  
    
    <!--        ************* OPCION 3 ESTUDIANTES POR GRUPOS  ************-->  
    <br>
    <li>
      <div class="collapsible-header hoverable"><i class="material-icons">contacts</i><b>Estudiantes por Grupo</b></div>
        <div class="collapsible-body">
            <!--        *************INICIO************-->  
            <ul id="tabs-swipe-demo" class="tabs bluetools">
               
                <li class="tab col s3 z-depth-5"><a href="#estudiantes-0" class="white-text"><b>Listar Estudiantes</b></a></li>
                
                <li class="tab col s3"><a href="#estudiantes-1" class="white-text"><b>Agregar Estudiantes</b></a></li>
                
                <li class="tab col s3 z-depth-5"><a href="#estudiantes-2" class="white-text"><b>Editar Estudiantes</b></a></li>
                
                <li class="tab col s3"><a href="#estudiantes-3" class="white-text"><b>Eliminar Estudiantes</b></a></li>
                
            </ul>
            
            <!--        *************LISTAR ESTUDIANTES POR GRUPO ************--> 
            <div id="estudiantes-0" class="col s12 white">
            <ul class="collapsible">
            <?php   
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DE GRUPOS ACTIVOS DEL DOCENTE
                $EstuGrupoDocente = mysqli_query($conex,
                    "SELECT * FROM grupo
                    WHERE id_docente = '".$DocenteLogueado."'");
                
                while($RCEGXD = mysqli_fetch_array($EstuGrupoDocente))
                {
                    $idGrupoG = $RCEGXD['id_grupo'];
                    $detalleG = $RCEGXD['detalle'];
                
                    //CONSULTAR TOTAL ESTUDIANTES POR GRUPO
                    $TotalEsGru = mysqli_query($conex,
                        "SELECT * FROM grupo,estudiante 
                        WHERE grupo.id_grupo = estudiante.id_grupo
                        AND estudiante.id_grupo = '".$idGrupoG."'");                    
                    $TotalesEstu =  mysqli_num_rows($TotalEsGru);    
            ?>
            <li>
                <div class="collapsible-header"><i class="material-icons">assistant_photo</i>
                <b>Grupo: <?php echo $detalleG ?></b><hr><b class="greentools-text">Total Estudiantes: &nbsp;</b><b><?php echo $TotalesEstu; ?></b></div>
                <div class="collapsible-body">
                <table class="centered highlight">
                <thead>
                  <tr>
                      <th>Codigo Estudiante</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Correo</th>
                      <th>Telefono</th>                     
                  </tr>
                </thead>

                <tbody>
            <?php
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DEL GRUPOS
                $EstuGrupo = mysqli_query($conex,
                    "SELECT * FROM grupo, estudiante
                    WHERE estudiante.id_grupo = grupo.id_grupo
                    AND estudiante.id_grupo = '".$idGrupoG."'
                    ORDER BY estudiante.apellido ASC ");
                
                while($RCEG = mysqli_fetch_array($EstuGrupo))
                {
                    $CodigoES = $RCEG['codigoe'];
                    $NomES = utf8_encode($RCEG['nombre']);
                    $ApellES = utf8_encode($RCEG['apellido']);
                    $correoES = utf8_encode($RCEG['correo']);
                    $telES = $RCEG['telefono'];
                    
                    
            ?>     
               <tr>
                    <td><?php echo $CodigoES; ?></td>
                    <td><?php echo $NomES; ?></td>
                    <td><?php echo $ApellES; ?></td>
                    <td><?php echo $correoES; ?></td>
                    <td><?php echo $telES; ?></td>                              
                </tr>  
            <?php  } ?>
                        
                </tbody>
              </table>

                </div>
            </li>
            <?php  }  ?> 
            </ul> 
            
            </div>
            
            <!--        *************AGREGAR ESTUDIANTES GRUPOS ************-->             
            <div id="estudiantes-1" class="col s12 greentools">
            <br>
            <h6 class="black-text center container"><b>Para agregar estudiantes lo puede realizar de dos formas:</b> <br><br><b>1) Estudiante por estudiante: </b> En esta opción usted podra crear un usuario tipo estudiante el cual será integrante de algúno de sus grupos a cargo.</b><br><br><b>2) Estudiantes por grupos: </b> En esta opción usted deberá subir un archivo <b class="white-text">.CSV</b> a partir de la <b class="white-text"> PLANTILLA</b> correspondinete, En ella debe agregar por cada fila un estudiante y guardar el archivo en la misma extension solicitada mediante separación por punto y coma ' ; ', se solicitrá el <b class="white-text">ID_GRUPO</b> para esto a continuación se muestra el listado de sus grupos con el ID_GRUPO correspondiente.
            <br> <br> <a href="estudiantes.csv" target="_blank" class="pulse"><b class="black-text btn redtools"><b>DESCARGAR PLANTILLA</b></b></a> <br>
            </h6> <br>
            <ul class="collapsible popout ">
            
            <!--        *************AGREGAR ESTUDIANTE ************--> 
            <li class="white ">
                <div class="collapsible-header hoverable"><i class="material-icons">person_add</i><b>Estudiante por Estudiante</b></div>
                <div class="collapsible-body">
                
                <?php 
            if($CuantosGruposXDocente == 0)
            {
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El docente no tiene grupos asignados</b></h5> <b> Comuniquese con el administrador del sitio para solicitar un grupo</b></div>';
            }
            else { ?>
            
        <div class="row">
        <form class="col s12" method="post" action="paneldoc.php">
        <div class="row">

            <div class="input-field col s6 mm6 l4">
            <input placeholder="2180123123" data-position="bottom" data-tooltip="Código Estudiantil | Necesario para Iniciar" id="codigo_eNE" type="number" name="codigo_eNE" class="validate tooltipped" required>
            <label for="codigo_eNE"class="black-text"><b>Código Estudiante</b></label>
            </div>

            <div class="input-field col s6 mm6 l4">
            <input data-position="bottom" data-tooltip="Nombres del Estudiantil" maxlength="100" minlength="2" id="nombre_eNE" type="text" name="nombre_eNE" class="validate tooltipped" required required pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+">
            <label for="nombre_eNE"class="black-text"><b>Nombre Estudiante</b></label>
            </div>
            
            <div class="input-field col s6 mm6 l4">
            <input data-position="bottom" data-tooltip="Apellidos del Estudiantil" maxlength="100" minlength="2" id="apellido_eNE" type="text" name="apellido_eNE" class="validate tooltipped" required pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+">
            <label for="apellido_eNE"class="black-text"><b>Apellido Estudiante</b></label>
            </div>
            
            <div class="input-field col s6 mm6 l4">
            <input data-position="bottom" data-tooltip="Correo del Estudiantil" maxlength="200" id="correo_eNE" type="email" name="correo_eNE" class="validate tooltipped" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
            <label for="correo_eNE"class="black-text"><b>Correo Estudiante</b></label>
            </div>
            
            
            <div class="input-field col s6 mm6 l4">
            <input data-position="bottom" data-tooltip="Telefono del Estudiantil 10 digitos" maxlength="10" id="telefono_eNE" type="text" name="telefono_eNE" class="validate tooltipped" required pattern="[0-9]{10}">
            <label for="telefono_eNE" class="black-text"><b>Telefono Estudiante</b></label>
            </div>
             
            <div class="input-field col s6 mm6 l4 tooltipped" data-position="bottom" data-tooltip="Grupo al que será agregado el estudiante">
            <select name="Grupo_eEE" id="Grupo_eEE" required  >
              <option value="" disabled selected class="greentools-text">Seleccione</option>
              <?php
              //CONSULTAR GRUPOS del Docente
                $GrupoParaEstu = mysqli_query($conex,
                    "SELECT * FROM grupo
                    WHERE id_docente = '".$DocenteLogueado."'
                    ORDER BY id_grupo ASC ");
                
                while($RCGPE = mysqli_fetch_array($GrupoParaEstu))
                {
                    $id_Grupo = $RCGPE['id_grupo'];
                    $detalle_Grupo = $RCGPE['detalle'];
            ?>     
               <option value="<?php echo $id_Grupo; ?>">Grupo: <?php echo $detalle_Grupo; ?></option>
               
            <?php  } ?>
                           
            </select>
            <label for="Grupo_eEE" class="black-text"><b>Seleccione el grupo</b></label>
            </div>
            
            <div class="input-field col s12 m6 push-m3">
                <button class="btn waves-effect waves-light col s12 bluetools white-text" type="submit" name="FANEAG" value="FANEAG" id="FANEAG">AGREGAR AL ESTUDIANTE
                <i class="material-icons right">send</i>
              </button>
            </div>

        </div>
        </form>
        </div>
                
                
            <?php } ?>
                </div>
            </li>
            
            
            <!--        *************AGREGAR ESTUDIANTE POR LOTES ************--> 
            <br>
            <li class="white ">
              <div class="collapsible-header hoverable"><i class="material-icons medium">group_add</i><b>Estudiantes por Grupos</b></div>
              
              <div class="collapsible-body">
               
                <?php 
            if($CuantosGruposXDocente == 0)
            {
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>El docente no tiene grupos asignados</b></h5> <b> Comuniquese con el administrador del sitio para solicitar un grupo</b></div>';
            }
            else { ?>
               
                <h6 class="center">A continuación se muestra el listado de sus grupos con el ID correspondiente, para agregarlo a la plantilla correspondiente; ya que es un campo obligatorio. <br>En la plantilla los campos obligatorios son <b>codigoe, nombre, apellido, id_grupo</b> <hr> <b class="red-text"> No cambie el nombre de la plantilla</b><hr></h6>
                <table class="highlight centered responsive-table container">
                <thead>
                  <tr>
                      <th><b>ID GRUPO</b></th>
                      <th><b>GRUPO</b></th> 
                       <th><b>AULA</b></th>                     
                  </tr>
                </thead>

                <tbody>
               
                <?php
                $GrupoIDES = mysqli_query($conex,
                    "SELECT * FROM grupo
                    WHERE id_docente = '".$DocenteLogueado."'");
                
                while($RCGIDS = mysqli_fetch_array($GrupoIDES))
                {
                    echo "
                    <tr>
                        <td>".$RCGIDS['id_grupo']."</td>
                        <td> Grupo ".$RCGIDS['detalle']."</td> 
                        <td>".$RCGIDS['aula']."</td>
                    </tr> ";
                        
                }
                ?>
                </tbody>
                </table> <br>
                <center>                    
                <div class="row container">
                <form action="paneldoc.php" method="post" enctype="multipart/form-data">
                    <div class="file-field input-field col s12 m9">
                      <div class="btn white-text bluetools">
                        <span>SUBIR LA PLANTILLA </span>
                        <input type="file" accept=".csv" name="archivo">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" required name="namePlantilla" placeholder="El archivo sede ser de extensión CSV separado por punto y coma ' ; '" type="text">
                      </div>
                    </div>
                    <div class="input-field col s12 m3 tooltipped" data-position="left" data-tooltip="Verifique el archivo antes de ser enviado">
                        <button class="btn waves-effect waves-light col s12 red " type="submit" name="FEPEL" id="FEPEL" ><b>ENVIAR DATOS</b>
                            <i class="material-icons right white-text">send</i>
                        </button>
                    </div>
                </form>
                </div>
                 </center>
               
               <?php } ?>   
              </div>
            </li>
           
            </ul>
            <br><br>
            </div>
            
            <!--        *************EDITAR ESTUDIANTE POR GRUPOS ************--> 
            <div id="estudiantes-2" class="col s12 white">
            
            <ul class="collapsible">
            <?php   
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DE GRUPOS ACTIVOS DEL DOCENTE
                $EstuGrupoDocente = mysqli_query($conex,
                    "SELECT * FROM grupo
                    WHERE id_docente = '".$DocenteLogueado."'");
                
                while($RCEGXD = mysqli_fetch_array($EstuGrupoDocente))
                {
                    $idGrupoG = $RCEGXD['id_grupo'];
                    $detalleG = $RCEGXD['detalle'];
                
                    //CONSULTAR TOTAL ESTUDIANTES POR GRUPO
                    $TotalEsGru = mysqli_query($conex,
                        "SELECT * FROM grupo,estudiante 
                        WHERE grupo.id_grupo = estudiante.id_grupo
                        AND estudiante.id_grupo = '".$idGrupoG."'");                    
                    $TotalesEstu =  mysqli_num_rows($TotalEsGru);    
            ?>
            <li>
                <div class="collapsible-header"><i class="material-icons">assistant_photo</i>
                <b>Grupo: <?php echo $detalleG ?></b><hr><b class="greentools-text">Total Estudiantes: &nbsp;</b><b><?php echo $TotalesEstu; ?></b></div>
                <div class="collapsible-body">
                
                <div class="row">
            <?php
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DEL GRUPOS
                $EstuGrupo = mysqli_query($conex,
                    "SELECT * FROM grupo, estudiante
                    WHERE estudiante.id_grupo = grupo.id_grupo
                    AND estudiante.id_grupo = '".$idGrupoG."'
                    ORDER BY estudiante.apellido ASC ");
                
                while($RCEG = mysqli_fetch_array($EstuGrupo))
                {
                    $CodigoES = $RCEG['codigoe'];
                    $NomES = utf8_encode($RCEG['nombre']);
                    $ApellES = utf8_encode($RCEG['apellido']);
                    $correoES = $RCEG['correo'];
                    $telES = $RCEG['telefono'];
                    
                    
            ?>   
                <form class="col s12 z-depth-1" method="post" action="paneldoc.php">
                <div class="row">
                   
                    <div class="input-field col s6 m6 l2">
                      <input placeholder="2180123456" id="codigoeEE" name="codigoeEE" type="number" class="validate" required value="<?php echo $CodigoES; ?>">
                      <label for="codigoeEE">Codigo Estudiante</label>
                    </div>
                   
                    <div class="input-field col s6 m6 l2">
                      <input placeholder="Pepito" id="nombreEE" name="nombreEE" type="text" class="validate" required value="<?php echo $NomES; ?>">
                      <label for="nombreEE">Nombre </label>
                    </div>
                    
                    <div class="input-field col s6 m6 l2">
                      <input placeholder="Perez" id="apellidoEE" name="apellidoEE" type="text" class="validate" required value="<?php echo $ApellES; ?>">
                      <label for="apellidoEE">Apellido </label>
                    </div>
                    
                    <div class="input-field col s6 m6 l2">
                      <input placeholder="correo@gmail.com" id="correoEE" name="correoEE" type="email" class="validate" required value="<?php echo $correoES; ?>">
                      <label for="correoEE">Correo </label>
                    </div>
                    
                    <div class="input-field col s6 m6 l2">
                      <input placeholder="3101231234" id="telefonoEE" name="telefonoEE" type="text" class="validate" required value="<?php echo $telES; ?>">
                      <label for="telefonoEE">Telelfono</label>
                    </div>
                    
                    <div class="input-field col s6 m6 l2">
                        <button class="btn waves-effect waves-light greentools white-text col s12" type="submit" name="ADEDG" id="ADEDG">Actualizar
                            <i class="material-icons right">send</i>
                        </button>                   
                    </div>
                </div>
                </form>
                 
                   
            <?php  } ?>
            </div>
            </div>
            </li>
            <?php  }  ?> 
            </ul> </div>
            
            <!--        *************ELIMINAR ESTUDIANTES ************--> 
            <div id="estudiantes-3" class="col s12 redtools">
            <br>
                <h6 class="black-text center container"><b>Para eliminar un estudiante no es necesario confirmar, por este motivo verifique muy bien su acción. Al eliminar un estudiante esté ya no podra tener acceso a la plataforma a menos que lo registgre nuevamente. así mismo, se eliminaran todos los datos de actividades, mensaje y notas asociados.</b>
                <br> <br>
                </h6> <br>
                
            <ul class="collapsible white">
            <?php   
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DE GRUPOS ACTIVOS DEL DOCENTE
                $EstuGrupoDocente = mysqli_query($conex,
                    "SELECT * FROM grupo
                    WHERE id_docente = '".$DocenteLogueado."'");
                
                while($RCEGXD = mysqli_fetch_array($EstuGrupoDocente))
                {
                    $idGrupoG = $RCEGXD['id_grupo'];
                    $detalleG = $RCEGXD['detalle'];
                
                    //CONSULTAR TOTAL ESTUDIANTES POR GRUPO
                    $TotalEsGru = mysqli_query($conex,
                        "SELECT * FROM grupo,estudiante 
                        WHERE grupo.id_grupo = estudiante.id_grupo
                        AND estudiante.id_grupo = '".$idGrupoG."'");                    
                    $TotalesEstu =  mysqli_num_rows($TotalEsGru);    
            ?>
            <li>
                <div class="collapsible-header"><i class="material-icons">assistant_photo</i>
                <b>Grupo: <?php echo $detalleG ?></b><hr><b class="greentools-text">Total Estudiantes: &nbsp;</b><b><?php echo $TotalesEstu; ?></b></div>
                <div class="collapsible-body">
                <center>
                <form id="act" name="act" method="POST" action="paneldoc.php" onsubmit="return confirmation()">
                
                <button class="btn waves-effect waves-light red black-text" type="submit" name="ETEDG" value="<?php echo $idGrupoG;?>"><b>ELIMINAR TODOS LOS ESTUDIANTES DEL GRUPO</b>
                <i class="material-icons right">send</i>
                </button>
                </form>
                
                </center><br>
                <table class="centered highlight">
                <thead class="redtools white-text">
                  <tr>
                      <th>Codigo Estudiante</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>Eliminar</th>                     
                  </tr>
                </thead>

                <tbody>
            <?php
                //------------------------------------------------
                //CONSULTAR ESTUDIANTES DEL GRUPOS
                $EstuGrupo = mysqli_query($conex,
                    "SELECT * FROM grupo, estudiante
                    WHERE estudiante.id_grupo = grupo.id_grupo
                    AND estudiante.id_grupo = '".$idGrupoG."'
                    ORDER BY estudiante.apellido ASC ");
                
                while($RCEG = mysqli_fetch_array($EstuGrupo))
                {
                    $CodigoES = $RCEG['codigoe'];
                    $NomES = utf8_encode($RCEG['nombre']);
                    $ApellES = utf8_encode($RCEG['apellido']);
                    $correoES = $RCEG['correo'];
                    $telES = $RCEG['telefono'];
                    
                    
            ?>     
               <tr>
                    <td><?php echo $CodigoES; ?></td>
                    <td><?php echo $NomES; ?></td>
                    <td><?php echo $ApellES; ?></td>
                    <td><?php echo $correoES; ?></td>
                    <td><?php echo $telES; ?></td>
                    <td><a href="paneldoc.php?deesgu=099af53f601532dbd31e0ea99ffdeb64&ieg=<?php echo $CodigoES; ?>&delete=true" class="btn redtools"><b>Eliminar</b></a></td>                              
                </tr>  
            <?php  } ?>
                        
                </tbody>
              </table>

                </div>
            </li>
            <?php  }  ?> 
            </ul> </div>
            <!--        *************FIN************-->  
        </div>
    </li>
    <!--        ************* FIN DE OPCION 3 ESTUDIANTES POR GRUPOS  ************-->  
    
    <!--        ************* OPCION 4 DOCENTES  ************--> 
    <?php if($EsAdmin == "true") { ?>
    <br>
    <li>
      <div class="collapsible-header hoverable"><i class="material-icons">person_pin</i><b>Docentes</b></div>
        <div class="collapsible-body">
            <!--        *************INICIO************-->  
            <ul id="tabs-swipe-demo" class="tabs bluetools">
                <li class="tab col s3 z-depth-5"><a href="#docente-0" class="white-text"><b>Listar Docentes</b></a></li>
                <li class="tab col s3"><a href="#docente-1" class="white-text"><b>Agregar Docentes</b></a></li>
                <li class="tab col s3 z-depth-5"><a href="#docente-2" class="white-text"><b>Editar Docentes</b></a></li>
                <li class="tab col s3"><a href="#docente-3" class="white-text"><b>Eliminar Docentes</b></a></li>
            </ul>
            
            <?PHP
            $HayDocentes = 0;
            $ArrayDatosDocentes = array ();
            
            //CONSULTAR DATOS DOCENTES
            $DatosDocentesA = mysqli_query($conex,
                "SELECT * FROM docente");
                                  
            while($RCDDA = mysqli_fetch_array($DatosDocentesA))
            {
                $HayDocentes ++;
                $ArrayDatosDocentes[]= array($RCDDA['id_docente'],$RCDDA['nombre'],$RCDDA['apellido'],$RCDDA['correo'],$RCDDA['telefono'],$RCDDA['clave']);
            }
            
            
            ?>
            <!--        *************LISTAR DOCENTES************-->  
            <div id="docente-0" class="col s12 white">
            <?php if($HayDocentes == 0) {            
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay docentes registrados en la plataforma</b></div>';
                } 
                else { ?>
                <table class="highlight centered">
                <thead class="z-depth-2">
                  <tr>                      
                      <th>Doc. Docente</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                  </tr>
                </thead>

                <tbody>
                
                <?PHP for($i=0;$i < $HayDocentes; $i++){  ?>
                <tr>                    
                    <td><?php echo $ArrayDatosDocentes[$i][0]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][1]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][2]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][3]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][4]; ?></td>
                    
                </tr>
                
                <?php }// FIN DEL FOR   ?>
                               
                </tbody>
                  </table>
                
            <?php 
                }//FIN ELSE ?>
            </div>
            
            <!--        *************AGREGAR DOCENTE************-->  
            <div id="docente-1" class="col s12 white">
            <br><br>
            <center>
            <div class="row container">
            <form class="col s12" method="post" action="paneldoc.php">
            <div class="row">
               
                <div class="input-field col s12 m6 l4">
                <input placeholder="Número de Documento" data-position="bottom" data-tooltip="Documento Docente | sin puntos ni comas" id="Id_DocenteFR" name="Id_DocenteFR" type="number" maxlength="10" minlength="5" required  class="validate tooltipped" pattern="[0-9]{4,6}">
                <label for="Id_DocenteFR" class="black-text"><b>Documento del Docente</b></label>
                </div>
                
                <div class="input-field col s12 m6 l4">
                <input placeholder="Nombre Docente" id="NomDocenteFR" name="NomDocenteFR" type="text" maxlength="100" minlength="3" required  class="validate" pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+">
                <label for="NomDocenteFR" class="black-text"><b>Nombre Docente</b></label>
                </div>
                
                
                <div class="input-field col s12 m6 l4">
                <input placeholder="Apellido Docente" id="ApellDocenteFR" name="ApellDocenteFR" type="text" maxlength="100" minlength="3" required  class="validate" pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+">
                <label for="ApellDocenteFR" class="black-text"><b>Apellido Docente</b></label>
                </div>
                
                <div class="input-field col s12 mm6 l4">
                <input data-position="bottom" data-tooltip="Correo Docente" maxlength="200" id="CorreoDoceFR" type="email" name="CorreoDoceFR" class="validate tooltipped" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                <label for="CorreoDoceFR" class="black-text"><b>Correo Doecente</b></label>
                </div>


                <div class="input-field col s12 mm6 l4">
                <input data-position="bottom" data-tooltip="Telefono Docente | 10 digitos" maxlength="10" id="TeleDocenteFR" type="text" name="TeleDocenteFR" class="validate tooltipped" required pattern="[0-9]{10}">
                <label for="TeleDocenteFR" class="black-text"><b>Telefono Docente</b></label>
                </div>
               
                <div class="input-field col s12 m6 push-m3">
                <button class="btn waves-effect waves-light col s12 bluetools white-text" type="submit" name="FADAP" value="FADAP" id="FANEAG">AGREGAR AL DOCENTE
                <i class="material-icons right">send</i>
              </button>
            </div>
            
            </div>
            </form>
           </div>
            </center>
            <br>
            </div>
            
            <!--        *************EDITAR DOCENTE************-->  
            <div id="docente-2" class="col s12 white"> <?php if($HayDocentes == 0) {            
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay docentes registrados en la plataforma</b></div>';
                } 
                else { ?>
                
                <br>
                
                <?PHP for($i=0;$i < $HayDocentes; $i++){  ?>
                <center>
                <div class="z-depth-3">
                <div class="row">
                <form class="col s12" method="post" action="paneldoc.php">
                <div class="row">
                    <input type="number" name="IdDocenAC" value="<?php echo $ArrayDatosDocentes[$i][0]; ?>" hidden>
                    
                    <div class="input-field col s12 m6 l2">
                    <input placeholder="Número de Documento" data-position="bottom" data-tooltip="Documento Docente | sin puntos ni comas" id="Id_DocenteFAC" name="Id_DocenteFAC" type="number" maxlength="10" minlength="5" required  class="validate tooltipped" pattern="[0-9]{4,6}" value="<?php echo $ArrayDatosDocentes[$i][0]; ?>">
                    <label for="Id_DocenteFAC " class="black-text"><b>Documento </b></label>
                    </div>

                    <div class="input-field col s12 m6 l2">
                    <input placeholder="Nombre Docente" id="NomDocenteFAC" name="NomDocenteFAC" type="text" maxlength="100" minlength="3" required  class="validate" pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+" value="<?php echo $ArrayDatosDocentes[$i][1]; ?>">
                    <label for="NomDocenteFAC" class="black-text"><b>Nombre</b></label>
                    </div>
                    

                    <div class="input-field col s12 m6 l2">
                    <input placeholder="Apellido Docente" id="ApellDocenteFAC" name="ApellDocenteFAC" type="text" maxlength="100" minlength="3" required  class="validate" pattern="[A-Za-z\sáéíóúÁÉÍÓÚ]+" value="<?php echo $ArrayDatosDocentes[$i][2]; ?>">
                    <label for="ApellDocenteFAC" class="black-text"><b>Apellido </b></label>
                    </div>

                    <div class="input-field col s12 m6 l2">
                    <input data-position="bottom" data-tooltip="Correo Docente" maxlength="200" id="CorreoDoceFAC" type="email" name="CorreoDoceFAC" class="validate tooltipped" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $ArrayDatosDocentes[$i][3]; ?>">
                    <label for="CorreoDoceFAC" class="black-text"><b>Correo </b></label>
                    </div>
                    

                    <div class="input-field col s12 m6 l1">
                    <input data-position="bottom" data-tooltip="Telefono Docente | 10 digitos" maxlength="10" id="TeleDocenteFAC" type="text" name="TeleDocenteFAC" class="validate tooltipped" required pattern="[0-9]{10}" value="<?php echo $ArrayDatosDocentes[$i][4]; ?>">
                    <label for="TeleDocenteFAC" class="black-text"><b>Telefono </b></label>
                    </div>

                   <div class="input-field col s12 m6 l1 switch">
                    <label>
                     <label for="ResetPWAC" class="black-text"><b>Resetea PW </b></label> <br>                      
                      <input type="checkbox" name="ResetPWAC" id="ResetPWAC">
                      <span class="lever"></span>  
                    </label>
                    </div>
                    
                    <div class="input-field col s12 m12 l2">
                    <button class="btn waves-effect waves-light greentools white-text" type="submit" name="FEDD" value="FEDD" id="FANEAG">ACTUALIZAR
                    <i class="material-icons right">send</i>
                    </button>
                    </div>

                </div>
                </form>
                </div>
               </div>
                </center> <br>
                
                <?php }// FIN DEL FOR   ?>
                               
                
                
            <?php 
                }//FIN ELSE ?>
            </div>
            
            <!--        *************ELIMINAR DOCENTE************-->  
            <div id="docente-3" class="col s12 white"> <?php if($HayDocentes == 0) {            
                echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay docentes registrados en la plataforma</b></div>';
                } 
                else { ?>
                <table class="highlight centered">
                <thead class="z-depth-2 redtools">
                  <tr>                      
                      <th>Doc. Docente</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>Eliminar</th>
                  </tr>
                </thead>

                <tbody>
                
                <?PHP for($i=0;$i < $HayDocentes; $i++){  ?>
                <tr>                    
                    <td><?php echo $ArrayDatosDocentes[$i][0]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][1]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][2]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][3]; ?></td>
                    <td><?php echo $ArrayDatosDocentes[$i][4]; ?></td>
                    <?php if($ArrayDatosDocentes[$i][0] == 1085277365) { ?>
                    <td><a class="btn white-text bluetools">ADMIN</a></td>
                    <?php } else { ?>
                    <td><a href="paneldoc.php?eddp=099af53f601532dbd31e0ea99ffdeb64&idd=<?php echo $ArrayDatosDocentes[$i][0]; ?>&delete=true" class="btn white-text redtools">ELIMINAR</a></td>
                    
                    <?php } ?>
                </tr>
                
                <?php }// FIN DEL FOR   ?>
                               
                </tbody>
                  </table>
                
            <?php 
                }//FIN ELSE ?>
            </div>
            <!--        *************FIN************-->  
        </div>
    </li>
    <?php }; ?>
    <!--        ************* OPCION 5 NOTICIAS GENERAL  ************--> 
    <br>
    <li>
      <div class="collapsible-header hoverable"><i class="material-icons">developer_board</i><b>Noticias General ToolsTic</b></div>
        <div class="collapsible-body">
            <!--        *************INICIO************-->  
            <ul id="tabs-swipe-demo" class="tabs bluetools">
                <li class="tab col s3 z-depth-5"><a href="#noticias-0" class="white-text"><b>Listar Noticias</b></a></li>
                <li class="tab col s3"><a href="#noticias-1" class="white-text"><b>Agregar Noticias</b></a></li>
                <li class="tab col s3 z-depth-5"><a href="#noticias-2" class="white-text"><b>Editar Noticias</b></a></li>
                <li class="tab col s3"><a href="#noticias-3" class="white-text"><b>Eliminar Noticias</b></a></li>
            </ul>
            
            <!--        *************LISTAR NOTICIAS ************--> 
            <div id="noticias-0" class="col s12 white active">
            <table class="highlight centered">
            <thead class="z-depth-2">
              <tr>
                  <th>No</th>
                  <th>Fecha publicación </th>                                   
                  <th>Título</th>
                  <th>Noticia</th>
                  
              </tr>
            </thead>

            <tbody>
           
            <?php
                //CONSULTAR NOTICIAS
                $HayNoticias = 0;
                
              $LasNoticias = mysqli_query($conex,"SELECT * FROM noticiastoolstic ORDER BY fecha DESC");
              while($RCTLN = mysqli_fetch_array($LasNoticias))
              {
                    $HayNoticias ++;
                    $id_noticia =$RCTLN['id_noticia'];
                    $fecha =$RCTLN['fecha'];
                    $titulo =$RCTLN['titulo'];
                    $mensaje =$RCTLN['mensaje'];
                  
            ?>  
                <tr>
                    <td><?php echo $HayNoticias; ?></td>
                    <td><?php echo strftime("%d-%B-%Y", strtotime($fecha));  ?></td>                    
                    <td><?php echo utf8_encode($titulo); ?></td>
                    <td WIDTH="60%"><?php echo utf8_encode($mensaje); ?></td>
                                                   
                </tr>
           
            <?php  } 
                
                if($HayNoticias == 0){
                    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay noticias publicados en la plataforma</b></div>';
                }
                
            ?>
                </tbody>
              </table>
           
            </div>
            
            <!--        *************AGREGAR NOTICIAS ************--> 
            <div id="noticias-1" class="col s12 greentools">
                <br>
                <h6 class="black-text center container"><b>Para agregar un nueva noticia complete el formulario siguiente; por el momento ToolsTic SOLO acepta noticias generales, es decir estas seran visibles para todos los usuarios sin importar el grupo al cual esten agregados.</b>
                <br> <br>
                </h6> <br>
                <h5 class="white">
                <center>
                <div class="container">
                <br><br>
                <form class="col s12" method="post" action="paneldoc.php">
                <div class="row">
                
                    <div class="input-field col s12 m6">
                      <input placeholder="Título de la Noticia" id="TituNoti" name="TituNoti" type="text" maxlength="50" minlength="3" class="validate" required data-length="50" pattern="[A-Za-z\sáéíóú]+">
                      <label for="TituNoti" class="black-text"><b>Título Noticia</b></label>
                    </div>
                                        
                    <div class="input-field col s12 m6">                      
                      <textarea placeholder="Noticia a publicar en ToolsTic" id="MensaNoti" name="MensaNoti" class="materialize-textarea" minlength="3"></textarea>
                      <label for="MensaNoti" class="black-text"><b>Mensaje de la Noticia</b></label>
                      
                    </div>
                    
                    <br>
                    <div class="row">
                        <div class="input-field col s12 m6">
                       <button class="btn waves-effect waves-light col s12 white-text bluetools" type="submit" name="FNNTT" value="FNNTT">Agregar Noticia
                        <i class="material-icons right">send</i>
                      </button>
                    </div>
                    </div>
                    
                </div>
                </form>                
                <br><br>
                </div>
                </center>
                
                </h5>
            </div>
            
            <!--        *************EDITAR NOTICIAS ************--> 
            <div id="noticias-2" class="col s12 white">
            <table class="highlight centered">
            <thead class="z-depth-2 blue">
              <tr>
                  <th width="8 %">No</th>                                                  
                  <th>Título</th>
                  <th>Noticia</th>
                  <th>Actualizar</th>
                  
              </tr>
            </thead>

            </table>
            <br>
            <?php
                //CONSULTAR NOTICIAS
                $HayNoticias = 0;
                
              $LasNoticias2 = mysqli_query($conex,"SELECT * FROM noticiastoolstic ORDER BY fecha DESC");
              while($RCTLN2 = mysqli_fetch_array($LasNoticias2))
              {
                    $HayNoticias ++;
                    $id_noticia =$RCTLN2['id_noticia'];
                    $fecha =$RCTLN2['fecha'];
                    $titulo =$RCTLN2['titulo'];
                    $mensaje =$RCTLN2['mensaje'];
                  
            ?>  
               <center>
                <div>
                <form class="col s12 align-center" method="post"  action="paneldoc.php">
                <div class="row center">
                   
                    <div class="input-field col s12 m1 align-center">
                        <b><?php echo $HayNoticias; ?> </b>
                    </div>
                    
                    <input type="number" name="IdNotiAC" hidden  value="<?php echo $id_noticia; ?>">
                    
                    
                    <div class="input-field col s12 m3">
                      <input placeholder="Título de la Noticia" id="TituNotiAC" name="TituNotiAC" type="text" maxlength="50" minlength="3" class="validate" value="<?php echo utf8_encode($titulo); ?>" required data-length="50" pattern="[A-Za-z\sáéíóú]+">
                      <label for="TituNotiAC" class="black-text"><b>Título Noticia</b></label>
                    </div> 
                                        
                    <div class="input-field col s12 m5">                      
                      <textarea placeholder="Noticia a publicar en ToolsTic" id="MensaNotiAC" name="MensaNotiAC" class="materialize-textarea" minlength="3"><?php echo utf8_encode($mensaje); ?> </textarea>
                      <label for="MensaNotiAC" class="black-text"><b>Mensaje de la Noticia</b></label>
                      
                    </div> 
                    
                    <br>
                    <div class="row">
                        <div class="input-field col s12 m2">
                       <button class="btn waves-effect waves-light col s12 white-text bluetools" type="submit" name="FALNT" value="FALNT">Actualizar Noticia
                        <i class="material-icons right">send</i>
                      </button>
                    </div> 
                    </div>
                    
                </div>
                </form>       
                                                   
                </div>
           </center>
            <?php  } 
                
                if($HayNoticias == 0){
                    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay noticias publicados en la plataforma</b></div>';
                }
                
            ?>
                
           
            </div>
            
            <!--        *************ELIMINAR NOTICIAS ************--> 
            <div id="noticias-3" class="col s12 white">
            
            <table class="highlight centered">
            <thead class="z-depth-2 redtools">
              <tr>
                  <th>No</th>
                  <th>Fecha publicación </th>                                   
                  <th>Título</th>
                  <th>Noticia</th>
                  <th>Eliminar</th>
              </tr>
            </thead>

            <tbody>
           
            <?php
                //CONSULTAR NOTICIAS
                $HayNoticias = 0;
                
              $LasNoticias = mysqli_query($conex,"SELECT * FROM noticiastoolstic ORDER BY fecha DESC");
              while($RCTLN = mysqli_fetch_array($LasNoticias))
              {
                    $HayNoticias ++;
                    $id_noticia =$RCTLN['id_noticia'];
                    $fecha =$RCTLN['fecha'];
                    $titulo =$RCTLN['titulo'];
                    $mensaje =$RCTLN['mensaje'];
                  
            ?>  
                <tr>
                    <td><?php echo $HayNoticias; ?></td>
                    <td><?php echo strftime("%d-%B-%Y", strtotime($fecha));  ?></td> 
                    <td><?php echo utf8_encode($titulo); ?></td>
                    <td WIDTH="50%"><?php echo utf8_encode($mensaje); ?></td>
                    <td><a href="paneldoc.php?ento=099af53f601532dbd31e0ea99ffdeb64&ni=<?php echo $id_noticia;?>&delete=true" class="btn redtools white-text">Eliminar</a></td>                              
                </tr>
           
            <?php  } 
                
                if($HayNoticias == 0){
                    echo '<div class="redtools center container hoverable "> <h5 class="bluetools-text"> <hr><i class="material-icons ">find_in_page</i> <b>No hay noticias publicados en la plataforma</b></div>';
                }
                
            ?>
                </tbody>
              </table>
           
           
            </div>
            <!--        *************FIN************-->  
        </div>
    </li>
    <!--        ************* FIN DE OPCION 4 NOTICIAS GENERAL  ************--> 
</ul>




<!-- *************** AGREGAR JS Y JQUERY **************-->
    <section>
    <!-- link para Jquery en sus dos versiones--> 
    <script src="../js/jquery-3.3.1.min.js"></script> 
    <script src="../js/materialize.min.js"></script>
    <script src="../js/sweetalrt.min.js"></script> 
        
    <script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
        $('select').formSelect();
        $('.tabs').tabs();
        $('.tooltipped').tooltip();
        $('input#TituNoti').characterCounter();
        //$('#MensaNoti').val('New Text');
        M.textareaAutoResize($('#MensaNoti, #MensaNotiAC'));
        
        $('#Menu_Panel').addClass('red'); 
        $('#Menu_Panel2').addClass('red'); 
        
        $(".dropdown-trigger").dropdown();
        
        $('.sidenav').sidenav({
            menuWidth: 200,
            edge: 'right',
            closeOnClick: true,
            open: true
        });   
                
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
        title: "UPPPS..!",
        text: "Hubo un error con la acción..!",
        icon: "warning",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $MensajeError = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************-->   
        
        
    // <!--        ***************** MODAL no existe el docente ***************-->
    <?php if ($NoExistedocente == true ){ ?>        
        swal({
        title: "Upps..!",
        text: "El docente no se encuentra registrado..!",
        icon: "warning",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $MensajeAFIRMA = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************--> 
        
    // <!--        ***************** MODAL no existe el docente ***************-->
    <?php if ($YaExisteElEstu == true ){ ?>        
        swal({
        title: "Upps..!",
        text: "El Estudiante ya está registrado en la plataforma..!",
        icon: "warning",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $YaExisteElEstu = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************--> 
    
    // <!--        ***************** MODAL no existe el docente ***************-->
    <?php if ($EstudianteRegistrados == true ){ ?>        
        swal({
        title: "Muy bien..!",
        text: "Los Estudiantes se registraron con Exito..!",
        icon: "success",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $EstudianteRegistrados = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************--> 
        
        
    // <!--        ***************** MODAL ya existe docente ***************-->
    <?php if ($YaExisteElDoce == true ){ ?>        
        swal({
        title: "Upsss..!",
        text: "El docente ya se encuentra registrado en la plataforma..!",
        icon: "warning",                
        timer: 3500,
        buttons: false              
        });         
    <?php  $YaExisteElDoce = false; }; ?>
    // <!--        *************** FIN MODAL WELCOME COOKIE *************--> 
        
        
        
    });
        
     
    function confirmation()
    {
       
        if(confirm("Realmente desea eliminar todos los estudaintes?"))
        {
            return true;
        }
        return false;
        
    }
        
    </script>
</section>
<!-- *************** FIN DE AGREGAR JS Y JQUERY **************-->
</body>
</html>