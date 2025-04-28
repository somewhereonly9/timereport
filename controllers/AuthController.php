<?php
require_once "../models/Usuario.php";
session_start();

$usuarioModelo = new Usuario();

if(isset($_POST['registro'])){
    $usuarioModelo->registrar($_POST['username'], $_POST['email'], $_POST['password']);
    header("Location: ../views/login.php");
}

if(isset($_POST['login'])){
    $usuario = $usuarioModelo->login($_POST['email'], $_POST['password']);
    if($usuario){
        $_SESSION['usuario'] = $usuario;
        header("Location: ../views/inicio.php");
    }else{
        header("Location: ../views/login.php?error=true");
    }
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: ../views/login.php");
}
?>