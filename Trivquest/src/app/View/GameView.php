<?php

require_once("src/app/Model/Trivia.php");
require_once("src/app/Model/Question.php");
require_once("src/app/Model/Answer.php");

class GameView
{
    private $notify;
    //Strings
    private $answerChoice;
    private $answer1;
    private $answer2;
    private $answer3;
    private $answer4;

    public function __construct(Notify $notify)
    {
        $this->notify = $notify;

        $this->answerChoice = 'answer';
        $this->answer1 = 0;
        $this->answer2 = 1;
        $this->answer3 = 2;
        $this->answer4 = 3;
    }
    public function getAnswer()
    {
        if (isset($_POST[$this->answerChoice]) && $_POST[$this->answerChoice] != '')
        {
            return $_POST[$this->answerChoice];
        }
        else
        {
            $this->notify->error("You need to provide an answer");
        }

        return null;
    }

    public function didProfile()
    {
        if(isset($_POST['goprofile']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function didRemoveTwo()
    {
        if(isset($_POST['useremovetwo']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function didSkip()
    {
        if(isset($_POST['useskip']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function didAnswer()
    {
        if (isset($_POST['submit'.$this->answerChoice.'']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function renderAnswers($answers)
    {
        $answersHTML = Array();

        for($i = 0; $i < count($answers); ++$i)
        {
            $disabled = '';
            $red = '';

            if($answers[$i]->getRemoved())
            {
                $disabled = 'disabled';
                $red = 'has-error';
            }

            $answersHTML[$i] = "<div class='col-lg-6'>
                                    <div class='input-group input-group-lg ".$red."'>
                                        <span class='input-group-addon'>
                                            <input type='radio' name='answer' value='".$i."' ".$disabled.">
                                        </span>
                                        <input type='text' class='form-control' disabled value='{$answers[$i]->getAnswer()}'>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->";
        }

        return $answersHTML;
    }

    public function renderGameField($removeTwo, $skip, $gold, $question, $answers, $isRemoveTwoUsed, $currentQuestion, $totalQuestions, $lives)
    {
        $removeTwoDisable = '';

        $answersHTML = $this->renderAnswers($answers);
        if($isRemoveTwoUsed)
        {
            $removeTwoDisable = 'disabled';
        }

        $body = "<div id='container'>
                    <form action='?action=".NavigationView::$actionPlay."' method='post'>
                        <div class='row'>
                            <div class='col-lg-3'>
                                <div class='panel panel-primary'>
                                    <div class='panel-heading'>
                                        <h3 class='panel-title'>Status</h3>
                                    </div>
                                    <div class='panel-body'>
                                        <div class='row marginb'>
                                            <div class='col-lg-6'>
                                                <h2><span class='label label-info'>Lives</span></h2>
                                            </div><!-- /.col-lg-6 -->

                                            <div class='col-lg-6 text-right'>
                                                <h2><span class='label label-info'> x $lives</span></h2>
                                            </div><!-- /.col-lg-6 -->
                                        </div>

                                        <div class='row marginb'>
                                            <div class='col-lg-6'>
                                                <h2><button type='submit' name='useremovetwo' class='btn btn-lg btn-success' $removeTwoDisable>Use 50/50</button></h2>
                                            </div><!-- /.col-lg-6 -->

                                            <div class='col-lg-6 text-right'>
                                                <h2><span class='label label-info'> x $removeTwo</span></h2>
                                            </div><!-- /.col-lg-6 -->
                                        </div>

                                        <div class='row marginb'>
                                            <div class='col-lg-6'>
                                                <h2><button type='submit' name='useskip' class='btn btn-lg btn-success'>Use Skip</button></h2>
                                            </div><!-- /.col-lg-6 -->

                                            <div class='col-lg-6 text-right'>
                                                <h2><span class='label label-info'> x $skip</span></h2>
                                            </div><!-- /.col-lg-6 -->
                                        </div>

                                        <h2><span class='label label-default'>Gold : $gold</span></h2>
                                    </div>
                                </div>

                                <h3><button type='submit' name='goprofile' class='btn btn-lg btn-block btn-primary'>Go back to profile</button></h3>
                            </div>
                            <div class='col-lg-9'>
                                <div class='panel panel-primary'>
                                    <div class='panel-heading'>
                                        <h3 class='panel-title'>Question $currentQuestion/$totalQuestions </h3>
                                    </div>
                                    <div class='panel-body'>
                                        <h2>$question</h2>
                                    </div>
                                </div>
                                <div class='row marginb'>
                                    ".$answersHTML[$this->answer1]."
                                    ".$answersHTML[$this->answer2]."
                                </div>
                                <div class='row marginb'>
                                    ".$answersHTML[$this->answer3]."
                                    ".$answersHTML[$this->answer4]."
                                </div>

                                <div class='text-right'>
                                    <button type='submit' name='submitanswer' class='btn btn-lg btn-block btn-primary'>Answer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                ";

        return $body;
    }
}