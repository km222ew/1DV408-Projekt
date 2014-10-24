<?php

class Answer
{
    private $answer;
    private $isCorrect;

    public function __construct($answer, $isCorrect)
    {
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getIsCorrect()
    {
        return $this->isCorrect;
    }
}