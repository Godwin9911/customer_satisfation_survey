<?php

namespace App\Models;

class Question
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findBySurvey($survey_id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM questions WHERE survey_id = ?');
        $stmt->execute([$survey_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function create($question, $survey_id)
    {
        $stmt = $this->pdo->prepare('INSERT INTO questions ( question, survey_id, created_at, updated_at) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$question, $survey_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }
}
