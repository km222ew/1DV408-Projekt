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

    private $triviaSession;

    public function __construct(Notify $notify)
    {
        $this->notify = $notify;
        $this->questionRep = new QuestionRepository();
        $this->userRep = new UserRepository();
        $this->gameSession = new GameSession();

        $this->triviaSession = "trivia";
    }

    public function getUserData($username)
    {
        $user = $this->userRep->getUserByName($username);

        return $user;
    }

    public function newGame()
    {
        $trivia = $this->questionRep->getQuestions();

        $this->gameSession->saveTriviaToSession($trivia);
    }

    public function updateTrivia(Trivia $trivia)
    {
        $this->gameSession->saveTriviaToSession($trivia);
    }

    public function getTrivia()
    {
        return $this->gameSession->loadTriviaFromSession();
    }

    public function getQuestion()
    {

    }

    public function getLives()
    {
        //Return lives from session
    }

    public function removeLife()
    {
        //TODO:Removelife
    }

    public function removeRemoveTwo()
    {
        //TODO:RemoveRemoveTwo
    }

    public function removeSkip()
    {
        //TODO:RemoveSkip
    }

    public function addGold()
    {
        //TODO:Addgold
    }

    public function addExp()
    {
        //TODO:Addexp
    }

    public function addLevel()
    {
        //TODO:Addlevel
    }
}