<?php

require_once("DAL/UserRepository.php");
require_once("User.php");
require_once("DAL/QuestionRepository.php");
require_once("Trivia.php");
require_once("Question.php");
require_once("Answer.php");
require_once("GameSession.php");


class GameModel
{
    private $notify;
    private $questionRep;
    private $userRep;
    private $gameSession;

    //Game values. Gold and exp reward per question answered correctly (even when using lifeline)
    private $goldReward;
    private $expReward;
    private $goldPenalty;
    private $expPenalty;
    //How many lifelines removed per use (1)
    private $removeTwoAmount;
    private $skipAmount;
    //Level and exptonextlevel increase
    private $level;
    private $expToNextLevel;

    //Used for calculating bonus reward if trivia is completed
    private $correctAnswers;

    public function __construct(Notify $notify)
    {
        $this->notify = $notify;
        $this->questionRep = new QuestionRepository();
        $this->userRep = new UserRepository();
        $this->gameSession = new GameSession();

        $this->goldReward = 50;
        $this->expReward = 100;
        $this->goldPenalty = 25;
        $this->expPenalty = 50;
        $this->removeTwoAmount = -1;
        $this->skipAmount = -1;
        $this->level = 1;
        $this->expToNextLevel = 1000;

        $this->correctAnswers = "correctanswers";
    }

    //Same as in ProfileModel. Maybe should store in session?
    public function getUserData($username)
    {
        $user = $this->userRep->getUserByName($username);

        return $user;
    }

    public function newGame()
    {
        $trivia = $this->questionRep->getQuestions();

        $this->saveTrivia($trivia);

        $_SESSION[$this->correctAnswers] = 0;
    }

    public function removeCurrentTrivia()
    {
        $this->gameSession->unsetTrivia();
    }

    public function loadTrivia()
    {
        return $this->gameSession->loadTriviaFromSession();
    }

    public function saveTrivia($trivia)
    {
        $this->gameSession->saveTriviaToSession($trivia);
    }

    public function isTriviaOver($username)
    {
        $trivia = $this->loadTrivia();

        if($trivia->isTriviaOver() && $trivia->getLives() > 0)
        {
            $this->removeCurrentTrivia();
            $this->notify->success('Congratulations, you completed a trivia! How about another round?');
            $this->giveTriviaReward($username);
            return true;
        }
        else if($trivia->getLives() <= 0)
        {
            $this->gameSession->unsetTrivia();
            $this->notify->info('You ran out of lives and the Trivia has ended. How about another round?');
            return true;
        }

        return false;
    }

    public function answerActiveQuestion($answerPos, $username)
    {
        $trivia = $this->loadTrivia();
        $answers = $trivia->getActiveQuestion()->getAnswers();
        $answer = $answers[$answerPos];

        if($answer->getIsCorrect())
        {
            $this->notify->success('Good job. '.$answer->getAnswer().' was the correct answer.');
            $_SESSION[$this->correctAnswers] += 1;
            $this->giveQuestionReward($username);
        }
        else
        {
            $trivia->removeLife();
            $this->notify->error(''.$answer->getAnswer().' is incorrect. You lost one life.');
            $this->giveQuestionPenalty($username);
        }

        $trivia->nextQuestion();

        $this->saveTrivia($trivia);
    }

    public function useRemoveTwo($username)
    {
        $user = $this->getUserData($username);

        if($user->getRemoveTwo() >= 1)
        {
            $trivia = $this->loadTrivia();

            if($trivia->getActiveQuestion()->getRemoveTwo())
            {
                $this->notify->error("You have already used 50/50 on this question");
                return;
            }

            $trivia->getActiveQuestion()->useRemoveTwo();
            $answers = $trivia->getActiveQuestion()->getAnswers();

            $totalRemoved = 2;

            //Highly ineffective. Could prob do better with more time.
            for($i = 0; $i < $totalRemoved; ++$i)
            {
                $randomAnswer = rand(0, 3);

                if(!$answers[$randomAnswer]->getIsCorrect() && !$answers[$randomAnswer]->getRemoved())
                {
                    $answers[$randomAnswer]->removeAnswer();
                }
                else
                {
                    --$i;
                }
            }

            $this->saveTrivia($trivia);

            $this->userRep->updateUserRemoveTwo($username, $this->removeTwoAmount);
            $this->notify->success('You have successfully used a 50/50. 2 wrong answers have been disabled.');
        }
        else
        {
            $this->notify->error("You don't have any 50/50 to use.");
        }
    }

    public function useSkip($username)
    {
        $user = $this->getUserData($username);

        if($user->getSkip() >= 1)
        {
            $trivia = $this->loadTrivia();
            $trivia->nextQuestion();
            $this->saveTrivia($trivia);

            $this->userRep->updateUserSkip($username, $this->removeTwoAmount);

            $this->giveQuestionReward($username);

            $this->notify->success('You have successfully used a Skip. The question has been skipped.');
        }
        else
        {
            $this->notify->error("You don't have any Skip to use.");
        }
    }

    private function giveTriviaReward($username)
    {
        $multiplier = $_SESSION[$this->correctAnswers];

        $totalGold = ($this->goldReward * $multiplier);

        $totalExp = ($this->expReward * ($multiplier / 2));

        $this->userRep->updateUserGold($username, $totalGold);
        $this->userRep->updateUserExp($username, $totalExp);

        $this->userDataCalc($username);

        $this->notify->info('(Trivia)Reward: '.$totalGold.' gold and '. $totalExp.' exp.');
    }

    private function giveQuestionReward($username)
    {
        $this->userRep->updateUserGold($username, $this->goldReward);
        $this->userRep->updateUserExp($username, $this->expReward);

        $this->userDataCalc($username);

        $this->notify->info('(Question) Reward: '.$this->goldReward.' gold and '. $this->expReward.' exp.');
    }

    private function giveQuestionPenalty($username)
    {
        $this->userRep->updateUserExp($username, -$this->expPenalty);
        $this->userRep->updateUserGold($username, -$this->goldPenalty);

        $this->notify->info('(Question) Penalty: -'.$this->goldPenalty.' gold and -'. $this->expPenalty.' exp.');

        $this->userDataCalc($username);
    }

    private function userDataCalc($username)
    {
        $user = $this->getUserData($username);
        $gold = $user->getGold();
        $exp = $user->getExp();
        $expToNextLevel = $user->getExpToNextLevel();

        if($gold < 0)
        {
            $gold = abs($gold);
            $this->userRep->updateUserGold($username, $gold);
        }

        if($exp < 0)
        {
            $exp = abs($exp);
            $this->userRep->updateUserExp($username, $exp);
        }

        if($exp >= $expToNextLevel)
        {
            $this->userRep->updateUserExpToNextLevel($username, $this->expToNextLevel);
            $this->userRep->updateUserLevel($username, $this->level);
        }
    }
}