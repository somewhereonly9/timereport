<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<header>
    <h1>TimeReport ©</h1>
</header>

<!-- Barra de navegación -->
<nav>
    <ul>
        <li><a href="home.php">Inicio</a></li>
        <li><a href="registro.php">Registro</a></li>
        <li><a href="consulta.php">Consulta</a></li>
        <li><a href="#">Informes</a></li>
        <li><a href="configuracion.php">Configuración</a></li>
    </ul>
    <div class="nav-user-container">
        <h3>Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</h3>
        <p>Has iniciado sesión correctamente.</p>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</nav>    
