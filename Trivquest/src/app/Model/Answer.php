<?php

class Answer
{
    private $answer;
    private $isCorrect;
    private $removed;

    public function __construct($answer, $isCorrect)
    {
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
        $this->removed = false;
    }

    public function getRemoved()
    {
        return $this->removed;
    }

    public function removeAnswer()
    {
        if($this->isCorrect)
        {
            $this->removed = false;
        }
        else
        {
            $this->removed = true;
        }
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