<?php
class Survey
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT * FROM surveys');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM surveys WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO surveys (title, description, opening_message, created_at, updated_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['opening_message'],
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        return $this->pdo->lastInsertId();
    }
}
