<?php

require_once('src/app/View/GameView.php');
require_once('src/app/Model/GameModel.php');

class GameController
{
    private $gameView;
    private $gameModel;

    public function __construct(Notify $notify, UserRepository $userRep)
    {
        $this->gameView = new GameView($notify);
        $this->gameModel = new GameModel($notify, $userRep);
    }

    public function newGame()
    {
        $this->gameModel->newGame();
    }

    public function removeTrivia()
    {
        $this->gameModel->removeCurrentTrivia();
    }

    public function isTriviaNull()
    {
        if($this->gameModel->loadTrivia() == null)
        {
            return true;
        }

        return false;
    }

    public function showGameField($username)
    {
        if($this->gameModel->isTriviaOver($username))
        {
            NavigationView::redirectProfile();
        }

        $this->checkInputs($username);

        $trivia = $this->gameModel->loadTrivia();

        $activeQuestion = $trivia->getActiveQuestion();
        $user = $this->getUser($username);

        return $this->gameView->renderGameField($user->getRemoveTwo(), $user->getSkip(), $user->getGold(), $activeQuestion->getQuestion(),
            $activeQuestion->getAnswers(), $activeQuestion->getRemoveTwo(), $trivia->getCurrentQuestion(),
            $trivia->getTotalQuestions(), $trivia->getLives());
    }

    private function getUser($username)
    {
        return $this->gameModel->getUserData($username);
    }

    private function checkInputs($username)
    {
        if($this->gameView->didProfile())
        {
            $this->gameModel->removeCurrentTrivia();
            NavigationView::redirectProfile();
        }

        if($this->gameView->didRemoveTwo())
        {
            $this->gameModel->useRemoveTwo($username);
            NavigationView::redirectPlay();
        }

        if($this->gameView->didSkip())
        {
            $this->gameModel->useSkip($username);
            NavigationView::redirectPlay();
        }

        if($this->gameView->didAnswer())
        {
            if($this->gameView->getAnswer() == null)
            {
                NavigationView::redirectPlay();
                return;
            }
            $this->gameModel->answerActiveQuestion($this->gameView->getAnswer(), $username);
            NavigationView::redirectPlay();
        }
    }



}