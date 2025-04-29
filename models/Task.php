public function registrarTarea($data) {
    $sql = "INSERT INTO tasks (project_id, company_id, name, description, date, assigned_to) 
            VALUES (:project_id, :company_id, :name, :description, :date, :assigned_to)";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':project_id' => $data['project_id'],
        ':company_id' => $data['company_id'],
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':date' => $data['date'],
        ':assigned_to' => $data['assigned_to']
    ]);
}