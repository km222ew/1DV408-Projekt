<?php

require_once('src/app/View/GameView.php');

class GameController
{
    private $gameView;

    public function __construct()
    {
        $this->gameView = new GameView();
    }

    public function showGameField()
    {
        return $this->gameView->renderGameField();
    }
}