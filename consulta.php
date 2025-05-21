<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/include/conexion.php';

// Obtener nombre para el header
$conexion = new Conexion();
$db = $conexion->getConnection();
$stmtUser = $db->prepare('SELECT first_name, last_name FROM users WHERE email = :email LIMIT 1');
$stmtUser->bindParam(':email', $_SESSION['email']);
$stmtUser->execute();
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);
$nombre = $user ? $user['first_name'] . ' ' . $user['last_name'] : $_SESSION['email'];

require_once __DIR__ . '/include/header.php';

?>
    <main class="layout">
        <!-- Barra lateral de filtros -->
        <aside class="sidebar-filters">
            <h2>Trabajos</h2>
            <form>
                <div class="filter-group">
                    <label for="grupo">Grupo de clientes</label>
                    <select id="grupo" name="grupo">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="cliente">Cliente</label>
                    <select id="cliente" name="cliente">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="proyecto">Proyecto</label>
                    <select id="proyecto" name="proyecto">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="encargado">Encargado comercial</label>
                    <select id="encargado" name="encargado">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="usuario">Usuario</label>
                    <select id="usuario" name="usuario">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="facturable">Facturable</label>
                    <select id="facturable" name="facturable">
                        <option value="">Todos</option>
                        <option value="yes">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="revisado">Revisado</label>
                    <select id="revisado" name="revisado">
                        <option value="">Todos</option>
                        <option value="yes">Sí</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <button class="btn-primary" type="submit">Filtrar</button>
            </form>
        </aside>

        <!-- Contenido principal -->
        <section class="main-content">
            <div class="stats-summary">
                <span id="registros">19 registros</span>
                <span>|</span>
                <span>Horas trabajadas <strong>60h&nbsp;00m</strong></span>
                <span>|</span>
                <span>Horas facturables <strong>50h&nbsp;00m</strong></span>
            </div>

            <div class="worklist">
                <!-- Ejemplo de ítem de trabajo -->
                <div class="work-item">
                    <div class="work-meta">
                        <p><strong>#6825</strong> · 16&nbsp;mayo&nbsp;2025</p>
                        <p>COSL de México (Laboral)</p>
                        <span class="tag">Facturable</span>
                        <p>Usuario: Luis Gerardo Aulis Izquierdo</p>
                    </div>

                    <div class="work-description">
                        <p>Exp: 582/2016 (Anatolio de la Cruz Aguilar)</p>
                        <p>Lugar: DR</p>
                        <p>Actividad: Elaboración de dictamen.</p>
                    </div>

                    <div class="work-duration">05h&nbsp;00m</div>
                    <div class="work-billable">05h&nbsp;00m</div>
                    <div class="work-rate">$&nbsp;300.00</div>
                    <div class="work-reviewed"><input type="checkbox"></div>
                    <div class="work-actions"><button title="Editar">&#9998;</button></div>
                </div>
                <!-- Duplica .work-item según sea necesario -->
            </div>
        </section>
    </main>
    <!-- Incluye tu footer aquí si lo necesitas -->

<?php
include_once 'include/footer.php';
?>