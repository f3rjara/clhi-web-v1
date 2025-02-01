<?php
include('../log/cnxlo.php');
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


<div class="navbar-fixed">

<nav class="bluetools">
    <div class="nav-wrapper ">
         <a href="./docente.php" class="brand-logo transparent-text " ><img src="../img/isologoLarge_toolstic.png" class="brand-logo responsive-img efectosubir">ToolsTicLarge</a> 
         
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons red-text">menu</i></a>
        
        <ul class="right hide-on-med-and-down">
           <li></li>
           <li><a href="paneldoc.php" class="white-text btn bluetools efectosubir hoverable" id="Menu_Panel"><b>Panel de Control</b></a></li>
            <li><a href="actividadesdoc.php" id="Menu_Actividades" class="white-text btn bluetools efectosubir hoverable"><b>Actividades</b></a></li>
            <li><a href="notasdoc.php" id="Menu_Notas"  class="white-text btn bluetools efectosubir hoverable"><b>Notas</b></a></li>
            <li><a href="buzondoc.php" id="Menu_Buzon" class="white-text btn bluetools efectosubir hoverable"><b>Buzon</b></a></li>
            <li><a href="perfil.php" id="Menu_Acerca" class="white-text btn bluetools efectosubir hoverable"><b>Acerca de</b></a></li>
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
          <img class="circle efectosubir" src="../img/docente.png">
          
          <a href="#"><span class="white-text name"><?php echo $Id_Docente; ?> </span></a>
          <a href="#"><span class="white-text name"><?php echo $NomDocente." ".$ApellDocente; ?> </span></a>
          <a href="#"><span class="white-text name"><?php echo $correoDocente; ?></span></a>
          <span class="name transparent-text">ToolsTic</span>
         </div>
    </li>  
    <li><a href="paneldoc.php" id="Menu_Panel2" class="white-text btn bluetools efectosubir hoverable"><b>Panel de Control</b></a></li>
    <li><a href="actividadesdoc.php" id="Menu_Actividades2"  class="white-text btn bluetools efectosubir hoverable"><b>Actividades</b></a></li>
    <li><a href="notasdoc.php" id="Menu_Notas2" class="white-text btn bluetools efectosubir hoverable"><b>Notas</b></a></li>
    <li><a href="buzondoc.php" id="Menu_Buzon2" class="white-text btn bluetools efectosubir hoverable"><b>Buzon de mensajes</b></a></li>
    <li><a href="perfil.php" id="Menu_Acerca2" class="white-text btn bluetools efectosubir hoverable"><b>Acerca de</b></a></li>
    <li><a href="../log/logout.php" class="bluetools-text redtools btn efectosubir hoverable"><b>Cerrar Sesión</b></a></li>
</ul>