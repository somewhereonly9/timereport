<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="form-container">
        <h3>Iniciar Sesión</h3>
        <form action="revisar.login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
