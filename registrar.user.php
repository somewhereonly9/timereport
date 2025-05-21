<?php
session_start();
require_once 'include/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';

    // Validación básica
    if (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        echo '<script>alert("Todos los campos son obligatorios.");window.location="registro.php";</script>';
        exit();
    }

    $password_md5 = md5($password);

    $conexion = new Conexion();
    $db = $conexion->getConnection();

    // Verificar si el usuario ya existe
    $stmt = $db->prepare('SELECT id FROM users WHERE email = :email  LIMIT 1');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->fetch()) {
        echo '<script>alert("email ya esta registrado.");window.location="registro.php";</script>';
        exit();
    }

    // Insertar el nuevo usuario
    $stmt = $db->prepare('INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_md5);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);

    if ($stmt->execute()) {
        echo '<script>alert("Registro exitoso. Ahora puedes iniciar sesión.");window.location="login.php";</script>';
        exit();
    } else {
        echo '<script>alert("Error al registrar usuario.");window.location="registro.php";</script>';
        exit();
    }
} else {
    header('Location: registro.php');
    exit();
}
?>
