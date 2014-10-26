<?php

require_once("DAL/UserRepository.php");
require_once("User.php");

class LoginModel {

    private $notify;
    private $userRep;
    private $token;

    //Strings
    private $usernameStr;
    private $userAgentStr;
    private $userIpStr;

	public function __construct(Notify $notify, UserRepository $userRep)
    {
		$this->notify = $notify;
        $this->userRep = $userRep;

        //Strings
        $this->usernameStr = 'username';
        $this->userAgentStr = 'userAgent';
        $this->userIpStr = 'userIp';
	}

	public function getUsername()
    {
		if (isset($_SESSION[$this->usernameStr]))
        {
			return $_SESSION[$this->usernameStr];
		}
        else
        {
			return '';
		}
	}

    //Look for user in database
    public function getUserFromDb($username)
    {
        $user = $this->userRep->getUserByName($username);

        return $user;
    }

	public function logout()
    {
		session_destroy();
		session_start();
		$this->notify->info('You have signed out');
	}

	//Is user already logged in?
	public function IsLoggedIn($userAgent, $userIp)
    {
		if (!isset($_SESSION[$this->usernameStr]))
        {
			return false;
		}

		$username = $_SESSION[$this->usernameStr];

        $user = $this->getUserFromDb($username);

        if($user != null && $_SESSION[$this->userAgentStr] == $userAgent && $_SESSION[$this->userIpStr] == $userIp)
        {
            return true;
        }
        else
        {
            return false;
        }
	}

    private function setSession($username, $userIp, $userAgent)
    {
        $_SESSION[$this->usernameStr] = $username;
        $_SESSION[$this->userIpStr] = $userIp;
        $_SESSION[$this->userAgentStr] = $userAgent;
    }

	//Validate credentials, used on login by post
	public function validateCredentials($username, $password, $userAgent, $userIp, $remember) {
		if ($username == '')
        {
			$this->notify->error('Username is missing');
			return false;
		}

		if ($password == '')
        {
			$this->notify->error('Password is missing');
			return false;
		}

        $user = $this->getUserFromDb($username);

        if($user == null || $password != $user->getPassword())
        {
            $this->notify->error('Wrong username and/or password');
            return false;
        }

        if($remember)
        {
            $this->notify->success('You successfully signed in and will be remembered next time');
        }
        else
        {
            $this->notify->success('You have successfully signed in');
        }

        $this->setSession($username, $userIp, $userAgent);

		return true;
	}

    public function loginWithCookies($usernameCookie, $tokenPassCookie, $userIP, $userAgent)
    {
        $user = $this->getUserFromDb($usernameCookie);

        if($user != null && $user->getToken() == $tokenPassCookie && $user->getExpire() > time())
        {
            $this->setSession($usernameCookie, $userIP, $userAgent);

            $this->notify->success('You have successfully been signed in with cookies');

            return true;
        }
        else
        {
            $this->notify->error('Wrong information in cookies');
            return false;
        }
    }

	//Saves token and cookie expiration
	public function rememberUser($expiration, $username)
    {
        $this->userRep->updateUserIdentifier($this->token, $expiration, $username);
	}

    //Generate, set, and return new token
    public function getToken()
    {
        $this->token = sha1(rand().microtime());

        return $this->token;
    }
}