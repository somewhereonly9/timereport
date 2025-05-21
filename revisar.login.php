<?php
session_start();
require_once 'include/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_md5 = md5($password);

    $conexion = new Conexion();
    $db = $conexion->getConnection();

    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_md5);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['email'] = $user['email'];
        header('Location: home.php');
        exit();
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos");window.location="login.php";</script>';
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>
