<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

echo "Hello, World!";
if(isset($_SESSION['usuario'])){
    header("Location: app/views/inicio.php");
} else {
    header("Location: app/views/login.php");
}
exit();
?>