<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4>Registro Usuario</h4>
            <form action="../controllers/AuthController.php" method="POST">
                <input type="hidden" name="registro" value="1">
                <input type="text" class="form-control mb-2" placeholder="Usuario" name="username" required>
                <input type="email" class="form-control mb-2" placeholder="Email" name="email" required>
                <input type="password" class="form-control mb-2" placeholder="Contraseña" name="password" required>
                <button type="submit" class="btn btn-success w-100">Registrarse</button>
                <a href="login.php" class="btn btn-link w-100 mt-2">Volver a Login</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
