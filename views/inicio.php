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
        <li><a href="../views/registro.php">Registro</a></li>
        <li><a href="#">Alta</a></li>
        <li><a href="#">Informes</a></li>
    </ul>
    <div class="nav-user-container">
        <h3>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['username']) ?>!</h3>
        <a href="../controllers/AuthController.php?logout=true" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</nav>

<!-- Contenido principal -->
<main>
    <h2>Bienvenido a mi aplicación web</h2>
    <p>Aquí va el contenido central de tu página.</p>
    <div class="form-container">
    <h3>Registro de actividades</h3>
    <div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="proyecto">Proyecto</label>
                <input type="text" class="form-control" id="proyecto" name="proyecto" required>
            </div>
            <div class="mb-3">
                <label for="Tarea">Cliente</label>
                <input type="text" class="form-control" id="cliente" name="cliente" required>
            </div>
            <!-- Usuario: send user_id as hidden, display username readonly -->
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['usuario']['id']) ?>">
            <div class="mb-3">
                <label for="usuario_display" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario_display" value="<?= htmlspecialchars($_SESSION['usuario']['username']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad</label>
                <textarea class="form-control" id="actividad" name="actividad" rows="4" required></textarea>
            </div>
            <div class="form-group">
                            <label>HORAS TRABAJADAS</label>
                            <div class="time-input">
                                <div class="time-display">
                                    <span id="hoursDisplay">00</span>:<span id="minutesDisplay">00</span>
                                </div>
                                <div class="time-controls">
                                    <div class="time-control-group">
                                        <button type="button" class="time-btn decrease" data-target="hours">−</button>
                                        <button type="button" class="time-btn increase" data-target="hours">+</button>
                                    </div>
                                    <div class="time-control-group">
                                        <button type="button" class="time-btn decrease" data-target="minutes">−</button>
                                        <button type="button" class="time-btn increase" data-target="minutes">+</button>
                                    </div>
                                </div>
                                <button type="button" class="time-start-btn">▶</button>
                            </div>
                        </div>

            <button type="submit" class="btn btn-primary">Registrar Actividad</button>
        </form>
    </div>
</div>
</main>

<!-- Pie de página -->
<footer>
    <p>&copy; 2025 Dagdug & Rangel Abogados. Todos los derechos reservados.</p>
</footer>


    <script src="../assets/app.js"></script>
</body>
</html>
