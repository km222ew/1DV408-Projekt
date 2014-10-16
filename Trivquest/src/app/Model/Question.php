<?php

class Question
{
    private $question;
    private $wrongAnswer1;
    private $wrongAnswer2;
    private $wrongAnswer3;
    private $correctAnswer;

    public function __construct($question, $wrongAnswer1, $wrongAnswer2, $wrongAnswer3, $correctAnswer)
    {
        $this->question = $question;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
        $this->correctAnswer = $correctAnswer;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getWrongAnswer1()
    {
        return $this->wrongAnswer1;
    }

    public function getWrongAnswer2()
    {
        return $this->wrongAnswer2;
    }

    public function getWrongAnswer3()
    {
        return $this->wrongAnswer3;
    }

    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }
}