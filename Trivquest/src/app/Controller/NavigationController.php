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
    public function doControl(Notify $notify, UserRepository $userRep)
    {
        $loginModel = new LoginModel($notify, $userRep);
        $loginView = new LoginView($loginModel);

        $loginController = new LoginController($loginModel, $loginView, $notify, $userRep);

        $controller = null;

        try
        {
            if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()) || $loginController->doCookieLogin())
            {
                $username = $loginModel->getUsername();

                //If on another page than play (where you play), remove any trivia from session to combat any cheating (like going back to buy new lifelines)
                if(NavigationView::getAction() != NavigationView::$actionPlay)
                {
                    $controller = new GameController($notify, $userRep);

                    $controller->removeTrivia();
                }

                switch(NavigationView::getAction())
                {
                    case NavigationView::$actionShowProfile:
                        $controller = new ProfileController($notify, $userRep);
                        return $controller->showProfile($username);
                    case NavigationView::$actionLogout:
                        $loginController->doLogout();
                        return $loginController->doLogin();
                    case NavigationView::$actionRegister:
                        //If you are logged in and for some reason move to the registration page, you will be logged out
                        if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()))
                        {
                            $loginController->doLogout();
                        }
                        return $loginController->doLogin();
                        break;
                    case NavigationView::$actionNewRound:
                        $controller = new GameController($notify, $userRep);
                        $controller->newGame();
                        NavigationView::redirectPlay();
                        break;
                    case NavigationView::$actionPlay:
                        $controller = new GameController($notify, $userRep);

                        if($controller->isTriviaNull())
                        {
                            $controller = new ProfileController($notify, $userRep);
                            return $controller->showProfile($username);
                        }
                        else
                        {
                            return $controller->showGameField($username);
                        }
                    default:
                        $controller = new ProfileController($notify, $userRep);
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
            session_destroy();
            return $loginController->doLogin();
        }

        return $loginController->doLogin();
    }
}