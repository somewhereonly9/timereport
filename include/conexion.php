<?php
class Conexion {
    // Atributos protegidos para poder ser heredados por otras clases
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pass = 'Rhaegar89$'; // Ajusta la contraseña si es necesario
    protected $dbname = 'timereport';
    protected $charset = 'utf8mb4';
    protected $connection;

    public function __construct() {
        $this->connect();
    }

    // Método que realiza la conexión a la base de datos
    protected function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            // Configuramos para que lance excepciones en caso de error
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    // Método para obtener la conexión
    public function getConnection() {
        return $this->connection;
    }
}
?>