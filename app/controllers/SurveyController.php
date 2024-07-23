<?php
require_once '../app/models/Survey.php';
require_once '../app/models/Question.php';
require_once '../app/models/SurveyCustomer.php';
require_once '../app/controllers/TwilioController.php';

class SurveyController
{
    private $pdo;
    private $surveyModel;
    private $questionModel;
    private $surveyCustomerModel;
    private $surveyCustomerRatingModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->surveyModel = new Survey($pdo);
        $this->questionModel = new Question($pdo);
        $this->surveyCustomerModel = new SurveyCustomer($pdo);
        $this->surveyCustomerRatingModel = new SurveyCustomerRating($pdo);
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // create survey
            $survey_id = $this->surveyModel->create($_POST);

            // error_log($survey_id);

            // create questions
            $questions = $_POST['questions'];

            // Iterate over the array and save each question
            foreach ($questions as $index => $question) {
                $this->questionModel->create($question, $survey_id);
            }

            // save customers phone numbers
            $phoneNumbers = $_POST['survey_customers'];

            // Iterate over the array and save each question
            foreach ($phoneNumbers as $index => $phone) {
                $this->surveyCustomerModel->create($phone, $survey_id);
            }

            // initiate call
            $twilioController = new TwilioController($this->pdo);
            $twilioController->initiateMultipleCalls($survey_id, $phoneNumbers);

            $_SESSION['message'] = 'Survey created successfully!';
            header('Location: /survey/create');
            exit;
        }
        ob_start();
        include '../app/views/survey/create.php';
        $content = ob_get_clean();
        include '../app/views/layout.php';
    }


    public function index()
    {
        $surveys = $this->surveyModel->all();
        ob_start();
        include '../app/views/survey/index.php';
        $content = ob_get_clean();
        include '../app/views/layout.php';
    }


    public function responses($id)
    {
        $customer_ratings = $this->surveyCustomerRatingModel->findBySurvey($id);

        error_log(print_r($customer_ratings, true));
        ob_start();
        include '../app/views/survey/responses.php';
        $content = ob_get_clean();
        include '../app/views/layout.php';
    }
}
