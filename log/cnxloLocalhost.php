<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "toolstic_v2_170718";


$conex = mysqli_connect($servidor, $usuario, $password, $bd);

if (!$conex) {    
    $estado = "Desconectado";
    exit;
}
else {
	$estado = "Conectado";    
}

?>	
