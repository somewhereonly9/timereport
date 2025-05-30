<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/include/conexion.php';

$conexion = new Conexion();
$db = $conexion->getConnection();

// cargar lista de proyectos y clientes
$stmtProj = $db->query('SELECT id, name FROM projects');
$projects = $stmtProj->fetchAll(PDO::FETCH_ASSOC);

$stmtComp = $db->query('SELECT id, name FROM companies');
$companies = $stmtComp->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare('SELECT first_name, last_name FROM users WHERE email = :email LIMIT 1');
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$nombre = $user ? $user['first_name'] . ' ' . $user['last_name'] : $_SESSION['email'];
?>
<?php
require_once __DIR__ . '/include/header.php';
?>
<!-- Contenido principal -->
<main>
    <h2>Welcome</h2>
    <p>Registra las actividades mediante el siguiente formulario.</p>
    <div class="form-container">
        <h3>Registro de actividades</h3>
            <form action="registrar_actividad.php" method="POST">
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label for="proyecto" class="form-label">Proyecto</label>
                    <select id="proyecto" name="proyecto_id" class="form-control" required>
                        <option value="">Seleccione un proyecto</option>
                        <?php foreach (
                            $projects as $pr): ?>
                            <option value="<?= $pr['id'] ?>"><?= htmlspecialchars($pr['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select id="cliente" name="cliente_id" class="form-control" required>
                        <option value="">Seleccione un cliente</option>
                        <?php foreach (
                            $companies as $co): ?>
                            <option value="<?= $co['id'] ?>"><?= htmlspecialchars($co['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>">
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
                </div>
            </div>
            <!-- Campo oculto para almacenar las horas trabajadas en minutos -->
            <input type="hidden" id="workMinutes" name="work_minutes" value="0">
            <input type="hidden" id="workHours" name="work_hours" value="0">
            <button type="submit" class="btn btn-primary">Registrar Actividad</button>
        </form>
    </div>
</main>

<!-- Pie de página -->
<?php
require_once __DIR__ . '/include/footer.php';
?>
<script src="assets/app.js"></script>

