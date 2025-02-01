<?php
include('../log/cnxlo.php');
//CONSULTAR DATOS DEL ESTUDIANTE INGRESADO
    $DatosEstudiante = mysqli_query($conex,"SELECT * FROM estudiante where codigoe = '".$_SESSION['estudiante']."'");
    while($RCDE = mysqli_fetch_array($DatosEstudiante))
    {
        $codigoEstudiante = $RCDE['codigoe'];
        $NomEstudiante = $RCDE['nombre'];
        $ApellidoEstudiante = $RCDE['apellido'];
        $correoEstudiante =  $RCDE['correo'];
        $telefonoEstudiante = $RCDE['telefono'];    
        $idGrupo =  $RCDE['id_grupo'];
    }  

?>
<div class="navbar-fixed">
<nav class="bluetools">
    <div class="nav-wrapper container">
        <a href="./consulta.php" class="brand-logo transparent-text " ><img src="../img/isologoLarge_toolstic.png" class="brand-logo responsive-img efectosubir">ToolsTicLarge</a> 
        
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons red-text">menu</i></a>
        
        <ul class="right hide-on-med-and-down">
            <li><a href="actividades.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Actividades"><b>Actividades</b></a></li>
            <li><a href="notas.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Notas"><b>Notas</b></a></li>
            <li><a href="buzon.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Buzon"><b>Buzon</b></a></li>
            <li><a href="acerca-de.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Acerca"><b>Acerca de</b></a></li>
            <li><a href="../log/logout.php" class="bluetools-text redtools btn efectosubir hoverable"><b>Cerrar Sesión</b></a></li>
        </ul>
    </div>
</nav>
</div>

<ul class="sidenav bluetools " id="mobile-demo">
   <li>
        <div class="user-view">
          <div class="background">
            <img src="../img/1.png" class="responsive-img">
          </div>
          <img class="circle efectosubir" src="../img/usuario2.png">
          
          <a href="#"><span class="white-text name"><?php echo $codigoEstudiante; ?> </span></a>
          <a href="#"><span class="white-text name"><?php echo $NomEstudiante." ".$ApellidoEstudiante; ?> </span></a>
          <a href="#"><span class="white-text name"><?php echo $correoEstudiante; ?></span></a>
          <span class="name transparent-text">ToolsTic</span>
         </div>
    </li>   
    <li><a href="actividades.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Actividades2"><b>Actividades</b></a></li>
    <li><a href="notas.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Notas2"><b>Notas</b></a></li>
    <li><a href="buzon.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Buzon2"><b>Buzon de mensajes</b></a></li>
    <li><a href="acerca-de.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Acerca2"><b>Acerca de</b></a></li>
    <li><a href="../log/logout.php" class="bluetools-text redtools btn efectosubir hoverable"><b>Cerrar Sesión</b></a></li>
</ul>