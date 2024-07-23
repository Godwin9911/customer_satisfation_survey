<?php
require_once '../vendor/autoload.php';
require_once '../app/models/Survey.php';
require_once '../app/models/Question.php';
require_once '../app/models/SurveyCustomer.php';
require_once '../app/models/SurveyCustomerRating.php';

use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

class TwilioController
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

    public function appUrl($requestUri)
    {
        // Determine the protocol (http or https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Get the domain name
        $domain = $_SERVER['HTTP_HOST'];

        // Construct the full URL
        $url = $protocol . $domain . $requestUri;

        // Return the URL
        return $url;
    }

    public function build_query_string($data)
    {
        $queryParams = $data;
        $queryString = http_build_query($queryParams);
        return $queryString;
    }

    public function initiateMultipleCalls($survey_id, $phoneNumbers = [])
    {
        // Your Twilio credentials from .env
        $twilioSid = $_ENV['TWILIO_SID'];
        $twilioToken = $_ENV['TWILIO_AUTH_TOKEN'];
        $twilioPhoneNumber = $_ENV['TWILIO_PHONE_NUMBER'];

        // Initialize Twilio client
        $twilio = new Client($twilioSid, $twilioToken);

        // Array to store call SIDs
        $callSids = [];



        try {

            // Initiate outbound calls
            foreach ($phoneNumbers as $phoneNumber) {
                error_log("send call");

                $queryString = $this->build_query_string([
                    'survey_id' => $survey_id,
                    'phoneNumber' => $phoneNumber,
                ]);

                error_log($phoneNumber);

                error_log($phoneNumber);

                $call = $twilio->calls->create(
                    $phoneNumber,
                    $twilioPhoneNumber,
                    [
                        'url' => $this->appUrl('/twilio/voice?' . $queryString, ),

                    ]
                );

                // Store call SID in array for tracking
                $callSids[] = $call->sid;
            }

            return "Done";

            // Output call SIDs for debugging or logging
            //  echo "Started calls: " . implode(', ', $callSids);
        } catch (\Exception $e) {
            // Handle errors
            echo "Error: " . $e->getMessage();
        }
    }

    public function voice()
    {
        $survey_id = $_GET['survey_id'];
        $phoneNumber = $_GET['phoneNumber'];

        error_log($phoneNumber);

        $queryString = $this->build_query_string([
            'survey_id' => $survey_id,
            'phoneNumber' => $phoneNumber,
            'opener' => 1
        ]);

        $response = new VoiceResponse();
        $gather = $response->gather([
            'input' => 'dtmf',
            'numDigits' => 1,
            'action' => $this->appUrl('/twilio/gather?' . $queryString),
            'timeout' => 10,           // Waits for 10 seconds after the last digit

        ]);

        $survey = $this->surveyModel->find($survey_id);
        $gather->say($survey['opening_message'] . ' Press 1 to continue, 2 to decline.');

        $response->say('We didn’t receive any input. Goodbye!');

        header('Content-Type: text/xml');
        echo $response;

    }

    public function gather()
    {
        // Retrieve the gathered digits from POST data
        $digits = "1";
        if (isset($_GET['Digits'])) {
            $digits = $_GET['Digits'];
        } elseif (isset($_POST['Digits'])) {
            $digits = $_POST['Digits'];
        }

        $opener = isset($_GET['opener']) ? $_GET['opener'] : null;
        $survey_id = isset($_GET['survey_id']) ? $_GET['survey_id'] : null;
        $phoneNumber = isset($_GET['phoneNumber']) ? $_GET['phoneNumber'] : null;
        $questionIndex = isset($_GET['questionIndex']) ? $_GET['questionIndex'] : null;
        $is_last_question = isset($_GET['is_last_question']) ? $_GET['is_last_question'] : null;
        $question_id = isset($_GET['question_id']) ? $_GET['question_id'] : null;

        // Create a new VoiceResponse instance
        $response = new VoiceResponse();

        error_log('digits');
        error_log($digits . '');

        if ($digits) {
            // Handle Opening Message Response
            if ($opener == '1') {
                // Ask first Question
                if ($digits == '1') {

                    $queryString = $this->build_query_string([
                        'survey_id' => $survey_id,
                        'phoneNumber' => $phoneNumber,
                        'questionIndex' => 0
                    ]);

                    $response->redirect(
                        $this->appUrl('/twilio/question?' . $queryString),
                    );
                } elseif ($digits == '2') {
                    $response->say('Thank you for your time. Goodbye.');
                }

            } else {
                $survey_customer = $this->surveyCustomerModel->findByPhoneAndsurvey($phoneNumber, $survey_id);
                error_log($digits . '');

                // Save answer to DB
                $this->surveyCustomerRatingModel->create([
                    "survey_id" => $survey_id,
                    "question_id" => $question_id,
                    "survey_customers_id" => $survey_customer['id'],
                    'phone' => $phoneNumber,
                    'rating' => $digits,
                ]);

                if ($is_last_question == '1') {
                    $response->say('Thank you for your time. Goodbye.');
                } else {
                    // Ask next question
                    $questionIndex = intval($questionIndex) + 1;

                    $queryString = $this->build_query_string([
                        'survey_id' => $survey_id,
                        'phoneNumber' => $phoneNumber,
                        'questionIndex' => $questionIndex
                    ]);

                    $response->redirect(
                        $this->appUrl('/twilio/question?' . $queryString),
                    );
                }

            }
        } else {
            // Say if no digits were pressed
            $response->say('No digits were pressed. Goodbye.');
        }

        // Output the response as XML
        header('Content-Type: text/xml');
        echo $response;

    }

    public function question()
    {
        $survey_id = isset($_GET['survey_id']) ? $_GET['survey_id'] : null;
        $phoneNumber = isset($_GET['phoneNumber']) ? $_GET['phoneNumber'] : null;
        $questionIndex = isset($_GET['questionIndex']) ? $_GET['questionIndex'] : null;

        // Get questions from Database
        $questions = $this->questionModel->findBySurvey($survey_id);

        // Get by index
        $questionIndex = intval($questionIndex);
        $question = $questions[$questionIndex];

        // error_log(print_r(($questions), true));

        // Check if there is next question
        $is_last_question = $questionIndex === array_key_last($questions) ? 1 : 0;

        $response = new VoiceResponse();

        $queryString = $this->build_query_string([
            'survey_id' => $survey_id,
            'phoneNumber' => $phoneNumber,
            'questionIndex' => $questionIndex,
            'is_last_question' => $is_last_question,
            'question_id' => $question['id']
        ]);

        $gather = $response->gather([
            'input' => 'dtmf',
            'numDigits' => 1,
            'action' => $this->appUrl(
                '/twilio/gather?' . $queryString
            ),
        ]);

        $gather->say($question['question']);

        $response->say('We didn’t receive any input. Goodbye!');

        header('Content-Type: text/xml');
        echo $response;

    }
}
