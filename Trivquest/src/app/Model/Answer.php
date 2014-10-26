<?php

class Answer
{
    //string
    private $answer;
    //bool
    private $isCorrect;
    //bool
    private $removed;

    public function __construct($answer, $isCorrect)
    {
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
        $this->removed = false;
    }

    //If the answer should be disabled (50/50 was used, aka removetwo)
    public function getRemoved()
    {
        return $this->removed;
    }

    //If the answer is the correct answer it will never be set to be disabled
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