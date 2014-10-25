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
        $stringAnswers = Array();

        foreach($this->answers as $answer)
        {
            $stringAnswers[] = $answer->getAnswer();
        }

        return $stringAnswers;
    }

    public function getRemoveTwo()
    {
        return $this->isRemoveTwoUsed;
    }

    public function useRemoveTwo()
    {
        $this->isRemoveTwoUsed = true;
    }

    public function answerQuestion(Answer $answer)
    {
        if($answer->getIsCorrect())
        {
            return true;
        }

        return false;
    }
}