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

    public function answerQuestion(Answer $answer)
    {
        if($answer->getIsCorrect())
        {
            return true;
        }

        return false;
    }
}