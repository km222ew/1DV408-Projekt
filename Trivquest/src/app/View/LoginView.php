<?php

require_once('src/components/cookie/cookie.service.php');

class LoginView {

	private $model;
	public $cookieService;

    //Strings
    private $username;
    private $inputUsername;
    private $password;
    private $remember;
    private $tokenPass;
    private $userAgent;
    private $userIp;
    private $login;
    private $action;
    private $register;

    public function __construct(LoginModel $model)
    {
        $this->model = $model;
        $this->cookieService = new CookieService;

        $this->username = 'username';
        $this->inputUsername = 'inputUsername';
        $this->password = 'password';
        $this->remember = 'remember';
        $this->tokenPass = 'tokenPass';
        $this->userAgent = 'HTTP_USER_AGENT';
        $this->userIp = 'REMOTE_ADDR';
        $this->login = 'login';
        $this->action = 'action';
        $this->register = 'register';
    }

	//Get username from post
	public function getUsername()
    {
		if (isset($_POST[$this->username]))
        {
			//Save username in cookie to remember input
			$this->cookieService->save($this->inputUsername, $_POST[$this->username], time()+3);
			return trim($_POST[$this->username]);
		}
		
		return '';
	}

	//Get password from post
	public function getPassword()
    {
		if (isset($_POST[$this->password]) && $_POST[$this->password] != '')
        {
			return trim($_POST[$this->password]);
		}

		return '';
	}

	//Remember user?
	public function getRemember()
    {
		if (isset($_POST[$this->remember]))
        {
            return true;
		}
        else
        {
			return false;
		}
	}

    //Get username stored in cookie
    public function getUsernameCookie()
    {
        return $_COOKIE[$this->username];
    }

    //Get token stored in cookie
    public function getTokenPassCookie()
    {
        return $_COOKIE[$this->tokenPass];
    }

	//Get client browser info
	public function getUserAgent()
    {
		return $_SERVER[$this->userAgent];
	}

    //Get client ip
    public function getUserIp()
    {
        return $_SERVER[$this->userIp];
    }

	//Did user request login?
	public function didLogin()
    {
		if (isset($_POST[$this->login]))
        {
			return true;
		}
        else
        {
			return false;
		}
	}

    //Did user go to register page
    public function goToRegister()
    {
        if(isset($_GET[$this->action]) && $_GET[$this->action] == $this->register)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	//Redirect, to get rid of post, changed to work with different pages
	public function redirect($pageId)
    {
        header("Location:$pageId");
	}

	//Page: login, page for logging in
	public function login()
    {

		$printUsername = $this->cookieService->load($this->inputUsername);

		$body = "
				<form action='?action=".NavigationView::$actionShowProfile."' class='form-signin' method='post'>
					    <h2 class='form-signin-heading'>Please sign in</h2>
						<input type='text' class='form-control input-lg marginb' placeholder='Username' id=$this->username name=$this->username value='$printUsername' required autofocus>
						<input type='password' class='form-control input-lg marginb' placeholder='Password' id=$this->password name=$this->password required>
						<label class='checkbox'>
                          <input type='checkbox' id=$this->remember name=$this->remember> Remember me
                        </label>
                        <div class='row'>
                            <div class='col-lg-6'>
                                <button type='submit' name=$this->login class='btn btn-primary btn-block'>Sign in</button>
                            </div>
                            <div class='col-lg-6'>
                                <a href='?action=".NavigationView::$actionRegister."' class='btn btn-primary btn-block'>Register</a>
                            </div>
                        </div>


				</form>";

		return $body;
	}

    public function createCookies($username, $tokenPass)
    {
        $time = time()+60;

        setcookie($this->username, $username, $time);
        setcookie($this->tokenPass, $tokenPass, $time);

        return $time;
    }

    public function deleteCookies()
    {
        setcookie($this->username, "", time()-1);
        setcookie($this->tokenPass,"", time()-1);
    }

    public function tokenPassCookieExist()
    {
        if(isset($_COOKIE[$this->tokenPass]) === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function usernameCookieExist()
    {
        if(isset($_COOKIE[$this->username]) === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}