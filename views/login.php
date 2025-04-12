<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4>Iniciar Sesión</h4>
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">Credenciales incorrectas</div>
            <?php endif; ?>
            <form action="../controllers/AuthController.php" method="POST">
                <input type="hidden" name="login" value="1">
                <input type="email" class="form-control mb-2" placeholder="Email" name="email" required>
                <input type="password" class="form-control mb-2" placeholder="Contraseña" name="password" required>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                <a href="registro.php" class="btn btn-link w-100 mt-2">Registrarme</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
