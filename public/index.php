<?php
session_start();

if(isset($_SESSION['usuario'])){
    header("Location: views/inicio.php");
} else {
    header("Location: views/login.php");
}
exit();
?>