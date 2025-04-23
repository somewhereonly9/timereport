<?php
session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

<!-- Encabezado -->
<header>
    <h1>TimeReport ©</h1>
</header>

<!-- Barra de navegación -->
<nav>
    <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Registro</a></li>
        <li><a href="#">Alta</a></li>
        <li><a href="#">Informes</a></li>
    </ul>
    <div class="container">
        <h3>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>!</h3>
        <a href="../controllers/AuthController.php?logout=true" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</nav>

<!-- Contenido principal -->
<main>
    <h2>Bienvenido a mi aplicación web</h2>
    <p>Aquí va el contenido central de tu página.</p>
</main>

<!-- Pie de página -->
<footer>
    <p>&copy; 2025 Dagdug & Rangel Abogados. Todos los derechos reservados.</p>
</footer>


    <script src="../assets/app.js"></script>
</body>
</html>
