<?php

require_once "../models/Task.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar los datos recibidos
    $data = [
        'project_id' => $_POST['project_id'],
        'company_id' => $_POST['company_id'],
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'date' => $_POST['date'],
        'assigned_to' => $_POST['assigned_to']
    ];

    // Instanciar el modelo y registrar la tarea
    $taskModel = new Task();
    $result = $taskModel->registrarTarea($data);

    if ($result) {
        echo "Task registered successfully!";
    } else {
        echo "Failed to register task.";
    }
}

?>