<?php
// models/CaseRepository.php
class CaseRepository {
    protected $conn;
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function findAll(): array {
        $sql = "
            SELECT 
                c.idCase,
                c.folio,
                c.fecha,
                a.name   AS actor_name,
                u.username AS lawyer_username,
                s.name   AS stage_name,
                d.name   AS defendant_name,
                comp.name AS company_name,
                auth.name  AS authority_name
            FROM cases c
            LEFT JOIN actors a   ON c.actor       = a.idactors
            LEFT JOIN users u    ON c.lawyer      = u.id
            LEFT JOIN stages s   ON c.stage       = s.idstages
            LEFT JOIN defendants d ON c.defendant = d.id
            LEFT JOIN companies comp ON c.company = comp.id
            LEFT JOIN authorities auth ON c.authority_id = auth.id
            ORDER BY c.fecha DESC
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}