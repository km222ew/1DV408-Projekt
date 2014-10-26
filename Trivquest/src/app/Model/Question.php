<?php

class Question
{
    //string
    private $question;
    //array (answer objects)
    private $answers;
    //bool
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

    //If a 50/50(aka removetwo) is used it flags this question so that it can't be used again
    public function useRemoveTwo()
    {
        $this->isRemoveTwoUsed = true;
    }
}