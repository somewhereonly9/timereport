<?php
class Conexion {
    private $host = "localhost";
    private $user = "root";
    private $password = "Rhaegar89$";
    private $db = "timereport";
    protected $conn;

    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Error conexión: " . $e->getMessage());
        }
    }
}
?>