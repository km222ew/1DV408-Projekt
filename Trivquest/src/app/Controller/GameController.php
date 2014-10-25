<?php

require_once('src/app/View/GameView.php');
require_once('src/app/Model/GameModel.php');

class GameController
{
    private $gameView;
    private $gameModel;

    public function __construct($notify)
    {
        $this->gameView = new GameView();
        $this->gameModel = new GameModel($notify);
    }

    private function getUser($username)
    {
        return $this->gameModel->getUserData($username);
    }

    public function newGame()
    {
        $this->gameModel->newGame();
    }

    public function showGameField($username)
    {
        $trivia = $this->gameModel->getTrivia();

        $currentQuestion = $trivia->getActiveQuestion();

        $question = $currentQuestion->getQuestion();
        $answers = $currentQuestion->getAnswers();

        $user = $this->getUser($username);

        return $this->gameView->renderGameField($user->getRemoveTwo(), $user->getSkip(), $currentQuestion->getQuestion(),
                                                $currentQuestion->getAnswers(), $trivia->getCurrentQuestion(),
                                                $trivia->getTotalQuestions(), $trivia->getLives());
    }
}