<?php

namespace App\Models;

class SurveyCustomerRating
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findBySurvey($survey_id)
    {
        $stmt = $this->pdo->prepare('SELECT * 
            FROM survey_customers_rating
            JOIN questions ON survey_customers_rating.question_id = questions.id
            WHERE survey_customers_rating.survey_id = ?');
        $stmt->execute([$survey_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function create($data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO survey_customers_rating (survey_id, question_id, survey_customers_id, phone, rating, created_at, updated_at ) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute(
            [
                $data['survey_id'],
                $data['question_id'],
                $data['survey_customers_id'],
                $data['phone'],
                $data['rating'],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ]
        );
    }
}
