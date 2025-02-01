<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "clhi_web";


$conex = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conex) {    
    $estado = "Desconectado";
    exit;
}
else {
	$estado = "Conectado";    
}

?>	
