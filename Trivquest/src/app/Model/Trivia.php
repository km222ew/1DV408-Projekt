<?php

class Trivia
{
    private $questions;
    private $lives;
    private $currentQuestion;
    private $totalQuestions;

    public function __construct($questions, $lives)
    {
        $this->questions = $questions;
        $this->lives = $lives;
        $this->currentQuestion = 0;
        $this->totalQuestions = count($questions);
    }

    public function removeLife()
    {
        $this->lives -= 1;
    }

    public function getLives()
    {
        return $this->lives;
    }

    public function getTotalQuestions()
    {
        return $this->totalQuestions;
    }

    public function getCurrentQuestion()
    {
        return $this->currentQuestion + 1;
    }

    public function isTriviaOver()
    {
        if($this->currentQuestion == $this->totalQuestions)
        {
            return true;
        }

        return false;
    }

    public function nextQuestion()
    {
        $this->currentQuestion += 1;
    }

    public function getActiveQuestion()
    {
        return $this->questions[$this->currentQuestion];
    }
}