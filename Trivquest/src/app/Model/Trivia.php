<?php

class Trivia
{
    //array (question objects)
    private $questions;
    //number
    private $lives;
    //Index for the list (numbers)
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
        if($this->lives <= 0)
        {
            return;
        }

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

    //Gets current question for display hence the +1 (maybe should not be made in the class)
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