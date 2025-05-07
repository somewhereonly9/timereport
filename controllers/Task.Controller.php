<?php
require_once __DIR__ . "/../models/Task.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que todos los campos requeridos estén presentes
    $requiredFields = ['fecha', 'proyecto', 'cliente', 'user_id', 'actividad', 'work_minutes'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            die("Error: Missing required field '$field'.");
        }
    }

    // Mapear los datos del formulario a los campos esperados por el modelo
    $data = [
        'project_id' => htmlspecialchars($_POST['proyecto']),
        'company_id' => htmlspecialchars($_POST['cliente']),
        'name' => 'Tarea',
        'description' => htmlspecialchars($_POST['actividad']),
        'date' => htmlspecialchars($_POST['fecha']),
        'assigned_to' => htmlspecialchars($_POST['user_id']),
        'work_minutes' => intval($_POST['work_minutes']) // Convertir a entero
    ];

    // Instanciar el modelo y registrar la tarea
    try {
        $taskModel = new Task();
        $result = $taskModel->registrarTarea($data);

        if ($result) {
            echo "Task registered successfully!";
        } else {
            echo "Failed to register task.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>