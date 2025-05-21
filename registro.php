<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
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
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>
