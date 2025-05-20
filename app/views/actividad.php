<div class="container">
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
                <label for="Tarea">Tareas</label>
                <input type="text" class="form-control" id="tarea" name="tarea" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>" readonly>
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