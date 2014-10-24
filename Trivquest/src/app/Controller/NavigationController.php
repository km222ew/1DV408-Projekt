<?php

require_once('LoginController.php');
require_once('ProfileController.php');
require_once('GameController.php');
require_once('src/app/Model/LoginModel.php');
require_once('src/app/View/LoginView.php');
require_once('src/app/View/LoginView.php');
require_once('src/app/View/NavigationView.php');
require_once("src/app/Model/DAL/QuestionRepository.php");


class NavigationController
{


    public function doControl(Notify $notify)
    {
        $loginModel = new LoginModel($notify);
        $loginView = new LoginView($loginModel);

        $loginController = new LoginController($loginModel, $loginView, $notify);

        $controller = null;

        $username = $loginModel->getUsername();

        try
        {
            /*$q = new QuestionRepository();

            $result = $q->getQuestions();

            print_r($result);*/

            if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()) || $loginController->doCookieLogin())
            {
                switch(NavigationView::getAction())
                {
                    case NavigationView::$actionShowProfile:
                        $controller = new ProfileController($notify);
                        return $controller->showProfile($username);
                    case NavigationView::$actionLogout:
                        $loginController->doLogout();
                        return $loginController->doLogin();
                    case NavigationView::$actionRegister:
                        if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()))
                        {
                            $loginController->doLogout();
                        }
                        return $loginController->doLogin();
                        break;
                    case NavigationView::$actionNewRound:
                        $controller = new GameController($notify);
                        $controller->newGame();
                        NavigationView::redirectPlay();
                        break;
                    case NavigationView::$actionPlay:
                        $controller = new GameController($notify);
                        return $controller->showGameField($username);
                    default:
                        $controller = new ProfileController($notify);
                        return $controller->showProfile($username);
                }
            }
            else
            {
                return $loginController->doLogin();
            }
        }
        catch(Exception $e)
        {
            echo "something went wrong";
            die();
        }
    }
}