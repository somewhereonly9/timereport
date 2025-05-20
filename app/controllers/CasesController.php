<?php
// controllers/CasesController.php
require_once __DIR__ . '/../models/CaseRepository.php';

class CasesController {
    protected $conn;
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Acción para listar todos los casos
    public function index() {
        $repo  = new CaseRepository($this->conn);
        $cases = $repo->findAll();
        // Pasamos $cases a la vista:
        include __DIR__ . '/../views/cases/index.php';
    }
}