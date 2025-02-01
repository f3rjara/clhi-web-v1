<!--Código PHP inicial-->
<section>
<?php 
    session_start();         
    if(isset($_SESSION['login'])){
        header('Location: ./main/consulta.php');
        exit();
    }
    elseif(isset($_SESSION['logindoc'])){
        header('Location: ./doic/docente.php');
        exit();
    }      
?>
</section>
<!--FIN Código PHP inicial-->
   
    
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>ToolsTic | Inicio</title>      
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <?php 
        header("Content-Type: text/html;charset=utf-8"); 
        include "php/hed.html";
        include "log/cnxlo.php";        
        include "js/funciones.js"; 
    ?>    
    
</head>
  
<body>
    <!--    Mensaje de bienvenida--> 
    <script language='javascript' type='text/javascript'>
        alertainicial();
    </script>
    <!--    FIN Mensaje de bienvenida-->    
    
    
    <div class="container">
        <div id="login-box">
            <div class="logo">
                <img src="img/isologo_toolstic.png" width="200px" class="img-hover rounded mx-auto d-block img-fluid" />
                <h1 class="logo-caption form_consulta"><span class="tweak">N</span>otas</h1>
                <h1 class="logo-caption form_login"><span class="tweak">L</span>ogin</h1>				
            </div><!-- /.logo -->
            <div id="respuesta"></div>
            <!--	FORMULARIO DE CONSULTA-->
			<div class="form_consulta">
				<form id="frmconsulta" method="post">
					<div class="controls">
						<input type="number" id="codigoe" placeholder="Código estudiantil" required class="form-control" />
				    	<button type="button" class="btn btn-default btn-block btn-custom" onclick="solicita_consulta()" id="consulta">Consultar</button>
					</div>					
				</form>
			</div>			
                   
            <!--	FORMULARIO DE INICIAR SESION-->
			<div class="form_login">
				<form method="post">
					<div class="controls">
						<input type="number" name="id_docente" id="usuario" placeholder="Usuario" required class="form-control" />		
						<input type="password" name="claveP" id="clave" placeholder="Contraseña" required class="form-control" />
						<button type="button" id="iniciar" class="btn btn-default btn-block btn-custom" onclick="iniciar_sesion()">Ingresar</button>
					</div>					
				</form>
			</div>
			<br>
			<!--	BOTONES DE INICIAR O CONSULTAR-->
			<div class="row">
				<br>
				<div class="col-xs-12 col-md-7 col-md-offset-7">					
					<button type="button" class="btn btn-primary btn-block " id="registrar"> &nbsp; Consultar Notas &nbsp;</button>
				</div>
				<div class="col-xs-12 col-md-6">
					<button type="button" class="btn btn-primary btn-block " id="mostrar">&nbsp; Iniciar Sesion &nbsp;</button>
				</div>
			</div>
					
			
       
        </div><!-- /#login-box -->
        
    </div><!-- /.container -->
    
    <!-- Container de particulas enlazadas a js -->
    <div id="particles-js"> </div> 
    
    
    <!-- ********************************************************** -->
        <script src="js/bootstrap.min.js"></script>         
    <!-- Codigo JavaScript Opcional -->
        <section>
        <script>
			$(document).ready(function() {formulariosiniciales();});
            $("#mostrar").on("click", function() {mostarloginindex(); });
			$("#registrar").on("click", function() {mostrarconsultaindex();});			

        </script>        
    </section>   
    <!-- ********************************************************** -->
    
</body>
    
</html>