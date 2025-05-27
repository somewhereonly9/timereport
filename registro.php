<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/include/conexion.php';

// Obtener nombre para el header
$conexion = new Conexion();
$db = $conexion->getConnection();
$stmtUser = $db->prepare('SELECT first_name, last_name FROM users WHERE email = :email LIMIT 1');
$stmtUser->bindParam(':email', $_SESSION['email']);
$stmtUser->execute();
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);
$nombre = $user ? $user['first_name'] . ' ' . $user['last_name'] : $_SESSION['email'];

require_once __DIR__ . '/include/header.php';
?>

    <h2>Registro de Usuario</h2>
    <form action="registrar.user.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="first_name">Nombre:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>
        <label for="last_name">Apellido:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>
        <button type="submit">Registrar</button>
    </form>
    <!-- <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p> -->

<?php
include_once 'include/footer.php';
?>