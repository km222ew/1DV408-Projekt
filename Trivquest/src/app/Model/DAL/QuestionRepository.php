<?php

require_once('src/app/Model/Answer.php');
require_once('src/app/Model/Question.php');
require_once('src/app/Model/Trivia.php');

class QuestionRepository extends Repository
{
    private $db;
    private $dbTable;

    //Db columns
    private static $question = "question";
    private static $wrongAnswer1 = "wronganswer1";
    private static $wrongAnswer2 = "wronganswer2";
    private static $wrongAnswer3 = "wronganswer3";
    private static $correctAnswer = "correctanswer";

    public function __construct()
    {
        $this->dbTable = "question";
        $this->db = $this->connectionQuestion();
    }

    public function getQuestions()
    {
        try
        {
            //Gets worse the more question in the database there are
            $sql = "SELECT * FROM $this->dbTable ORDER BY RAND() LIMIT 10";

            $query = $this->db->prepare($sql);

            $query->execute();

            $result = $query->fetchAll();

            $questions = $this->processResult($result);

            $trivia = new Trivia($questions, 5);

            return $trivia;
        }
        catch(PDOException $e)
        {
            die("An error has occurred. Error code 333");
        }
    }

    private function processResult($result)
    {
        $questions = null;

        foreach($result as $question)
        {
            $wA1 = new Answer($question[self::$wrongAnswer1], false);
            $wA2 = new Answer($question[self::$wrongAnswer2], false);
            $wA3 = new Answer($question[self::$wrongAnswer3], false);
            $cA = new Answer($question[self::$correctAnswer], true);

            $answers = [$wA1, $wA2, $wA3, $cA];

            shuffle($answers);

            $q = new Question($question[self::$question], $answers);

            $questions[] = $q;
        }

        return $questions;
    }
}