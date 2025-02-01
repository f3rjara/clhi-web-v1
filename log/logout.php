<?php

session_start();

unset($_SESSION['login']);
unset($_SESSION['logindoc']);
session_destroy();

if(isset($_COOKIE["mostrarModal"]))
{
    $expirar = 43200;
    setcookie('mostrarModal','SI',(time()-$expirar));
    $exibirModal = true;
}

header('Location: ../index.php');

exit();

   