<?php

class RegisterView
{
    private $cookieService;

    //Strings
    private $regUsername;
    private $regPassword;
    private $repRegPassword;
    private $register;
    private $inputUsername;

    public function __construct()
    {
        $this->cookieService = new CookieService;

        $this->regUsername = 'regUsername';
        $this->regPassword = 'regPassword';
        $this->repRegPassword = 'repRegPassword';
        $this->register = 'register';
        $this->inputUsername = 'inputUsername';
    }

    public function getUsername()
    {
        if(isset($_POST[$this->regUsername]))
        {
            return trim($_POST[$this->regUsername]);
        }

        return '';
    }

    public function getPassword()
    {
        if(isset($_POST[$this->regPassword]))
        {
            return trim($_POST[$this->regPassword]);
        }

        return '';
    }

    public function getRepeatedPassword()
    {
        if(isset($_POST[$this->repRegPassword]))
        {
            return trim($_POST[$this->repRegPassword]);
        }

        return '';
    }

    public function didRegister()
    {
        if(isset($_POST[$this->register]))
        {
            $this->cookieService->save($this->inputUsername, $this->getUsername(), time()+60);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function register() {

        $printUsername = $this->cookieService->load($this->inputUsername);

        //Replaces all invalid characters with '' and puts the remainder in input
        $printUsername = preg_replace('/[^a-zåäöA-ZÅÄÖ0-9]/', '', $printUsername);

        $body = "
				<a href='index.php' class='btn btn-lg btn-primary'>Tillbaka</a>
				<h2>Registrera användare</h2>
				<form action='?action=$this->register' method='post'>
					<fieldset>
						<legend>Skriv in användarnamn och lösenord</legend>
						<label for=$this->regUsername>Username</label>
						<input type='text' id=$this->regUsername name=$this->regUsername value='$printUsername'>
						<label for=$this->regPassword>Password</label>
						<input type='password' id=$this->regPassword name=$this->regPassword>
						<label for=$this->repRegPassword>Repeat password</label>
						<input type='password' id=$this->repRegPassword name=$this->repRegPassword>
						<button type='submit' name=$this->register class='btn btn-primary'>Registrera</button>
					</fieldset>
				</form>";

        return $body;
    }
}