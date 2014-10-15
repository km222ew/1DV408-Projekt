<?php

require_once('LoginController.php');
require_once('ProfileController.php');
require_once('GameController.php');
require_once('src/app/Model/LoginModel.php');
require_once('src/app/View/LoginView.php');
require_once('src/app/View/LoginView.php');
require_once('src/app/View/NavigationView.php');


class NavigationController
{


    public function doControl(Notify $notify)
    {
        $loginModel = new LoginModel($notify);
        $loginView = new LoginView($loginModel);

        $loginController = new LoginController($loginModel, $loginView, $notify);

        $controller = null;

        try
        {
            if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()) || $loginController->doCookieLogin())
            {
                switch(NavigationView::getAction())
                {
                    case NavigationView::$actionShowProfile:
                        $controller = new ProfileController($notify);
                        return $controller->showProfile($loginModel->getUsername());
                        break;
                    case NavigationView::$actionLogout:
                        $loginController->doLogout();
                        return $loginController->doLogin();
                        break;
                    case NavigationView::$actionRegister:
                        if($loginModel->IsLoggedIn($loginView->getUserAgent(), $loginView->getUserIp()))
                        {
                            $loginController->doLogout();
                        }
                        return $loginController->doLogin();
                        break;
                    case NavigationView::$actionPlay:
                        $controller = new GameController();
                        return $controller->showGameField();

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