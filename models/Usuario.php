<?php
require_once "Conexion.php";

class Usuario extends Conexion {

    public function registrar($nombre, $email, $password){
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute(['nombre'=>$nombre, 'email'=>$email, 'password'=>$hash]);
    }

    public function login($email, $password){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($password, $usuario['password'])){
            return $usuario;
        }
        return false;
    }
}
