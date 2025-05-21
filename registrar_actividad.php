<?php
session_start();
require_once 'include/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: home.php');
    exit();
}

// Recuperar datos del formulario
$fecha       = $_POST['fecha'] ?? '';
$proyectoId  = $_POST['proyecto_id'] ?? null;
$clienteId   = $_POST['cliente_id'] ?? null;
$actividad   = trim($_POST['actividad'] ?? '');
$workMinutes = intval($_POST['work_minutes'] ?? 0);

// Validación básica
if (!$fecha || !$proyectoId || !$clienteId || !$actividad) {
    echo '<script>alert("Todos los campos son obligatorios."); window.location = "home.php";</script>';
    exit();
}

// Calcular horas y minutos
$hours   = intdiv($workMinutes, 60);
$minutes = $workMinutes % 60;

// Conectar a la BD
$conexion = new Conexion();
$db = $conexion->getConnection();

try {
    // Obtener ID de usuario
    $stmtU = $db->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
    $stmtU->bindParam(':email', $_SESSION['email']);
    $stmtU->execute();
    $user   = $stmtU->fetch(PDO::FETCH_ASSOC);
    $userId = $user['id'] ?? null;
    if (!$userId) {
        throw new Exception('Usuario no encontrado');
    }

    // Insertar en tasks
    $sql = 'INSERT INTO tasks (project_id, company_id, name, description, date, assigned_to, hours_worked, minutes_worked) VALUES
            (:proj, :comp, :name, :desc, :date, :user, :hrs, :mins)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':proj',  $proyectoId, PDO::PARAM_INT);
    $stmt->bindParam(':comp',  $clienteId,  PDO::PARAM_INT);
    $stmt->bindParam(':name',  $actividad);
    $stmt->bindParam(':desc',  $actividad);
    $stmt->bindParam(':date',  $fecha);
    $stmt->bindParam(':user',  $userId,     PDO::PARAM_INT);
    $stmt->bindParam(':hrs',   $hours,      PDO::PARAM_INT);
    $stmt->bindParam(':mins',  $minutes,    PDO::PARAM_INT);
    $stmt->execute();

    echo '<script>alert("Actividad registrada exitosamente."); window.location = "home.php";</script>';
} catch (Exception $e) {
    echo '<script>alert("Error: ' . addslashes($e->getMessage()) . '"); window.location = "home.php";</script>';
}
?>