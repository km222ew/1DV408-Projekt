<?php

require_once('src/app/Model/RegisterModel.php');
require_once('src/app/View/RegisterView.php');

class LoginController {

	private $model;
    private $registerModel;
	private $view;
    private $registerView;
    private $notify;

	public function __construct(LoginModel $loginModel, LoginView $loginView, Notify $notify)
    {
		$this->model = $loginModel;
        $this->registerModel = new RegisterModel($notify);
		$this->view = $loginView;
        $this->registerView = new RegisterView();
        $this->notify = $notify;
	}

    //Create new cookies on login with cookies
    public function createCookies($username)
    {
        $expiration = $this->view->createCookies($username, $this->model->getToken());
        $this->model->rememberUser($expiration, $username);
    }

	//Try to login with provided credentials
	private function validateLogin()
    {
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
        $remember = $this->view->getRemember();
        $userAgent = $this->view->getUserAgent();
        $userIp = $this->view->getUserIp();

		//Check if credentials are correct
		if ($this->model->validateCredentials($username, $password, $userAgent, $userIp, $remember))
        {
            if($remember)
            {
                $this->createCookies($username);
                /*$expiration = $this->view->createCookies($username, $this->model->getToken());
                $this->model->rememberUser($expiration, $username);*/
            }

			return true;
		}
        else
        {
			return false;
		}
	}

    public function doLogout()
    {
        //Log user out
        $this->model->logOut();

        //If there are cookies present, delete them
        if($this->view->usernameCookieExist() || $this->view->tokenPasscookiesExist())
        {
            $this->view->deleteCookies();
        }
    }

    public function doCookieLogin()
    {
        if($this->view->usernameCookieExist() && $this->view->tokenPasscookiesExist())
        {
            if($this->model->loginWithCookies($this->view->getUsernameCookie(), $this->view->getTokenPassCookie(),
                $this->view->getUserIP(), $this->view->getUserAgent()))
            {
                //Refresh cookies and view logged in page
                $this->createCookies($this->view->getUsernameCookie());
                return true;
            }
            else
            {
                //If something is wrong with the cookies, delete them
                $this->view->deleteCookies();
                return false;
            }
        }
        else if($this->view->usernameCookieExist() || $this->view->tokenPasscookiesExist())
        {
            $this->view->deleteCookies();
            return false;
        }
    }

	public function doLogin()
    {
        //Did user want to login?
        if ($this->view->didLogin())
        {
            //Get rid of post request
            $this->view->redirect("index.php");

            //Validate credentials (post)
            if ($this->validateLogin())
            {

                $this->view->redirect("?action=".NavigationView::$actionShowProfile);
                //Show logged in page
                //return $this->view->loggedIn();
            }
        }

        //Did user want to register
        if($this->registerView->didRegister())
        {
            $username = $this->registerView->getUsername();
            $password = $this->registerView->getPassword();
            $repPassword = $this->registerView->getRepeatedPassword();

            //Check if the inputs are valid
            if($this->registerModel->validateRegister($username, $password, $repPassword))
            {
                //Get rid of post request
                $this->view->redirect("index.php");

                return $this->view->login();
            }

            //Get rid of post request
            $this->view->redirect("?action=register");
            return $this->registerView->register();
        }

        //Did user go to register page
        if($this->view->goToRegister())
        {
            return $this->registerView->register();
        }

		return $this->view->login();
	}
}