<?php

class Question
{
    private $question;
    private $answers;
    private $isRemoveTwoUsed;

    public function __construct($question, $answers)
    {
        $this->question = $question;
        $this->answers = $answers;
        $this->isRemoveTwoUsed = false;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getRemoveTwo()
    {
        return $this->isRemoveTwoUsed;
    }

    public function useRemoveTwo()
    {
        $this->isRemoveTwoUsed = true;
    }
}