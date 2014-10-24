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

    private function getLives()
    {

    }

    public function newGame()
    {
        $this->gameModel->newGame();
    }

    public function showGameField($username)
    {
        $user = $this->getUser($username);

        return $this->gameView->renderGameField($user->getRemoveTwo(), $user->getSkip());
    }
}