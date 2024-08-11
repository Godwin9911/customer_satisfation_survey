<?php

namespace App\Models;

class SurveyCustomer
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByPhoneAndsurvey($phone, $survey_id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM survey_customers WHERE survey_id = ? AND phone = ?');
        $stmt->execute([$survey_id, $phone]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($phone, $survey_id)
    {
        $stmt = $this->pdo->prepare('INSERT INTO survey_customers (phone, survey_id, created_at, updated_at) VALUES (?, ?, ?, ?)');
        return $stmt->execute([
            $phone,
            $survey_id,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
    }
}
