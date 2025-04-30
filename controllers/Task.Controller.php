<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'project_id' => $_POST['proyecto'],
        'company_id' => $_POST['cliente'],
        'name' => $_POST['actividad'],
        'description' => $_POST['actividad'],
        'date' => $_POST['fecha'],
        'assigned_to' => $_SESSION['usuario']['id'],
    ];
    
    if ($taskModel->registrarTarea($data)) {
        header("Location: ../views/inicio.php?success=true");
    } else {
        header("Location: ../views/inicio.php?error=true");
    }
}

?>