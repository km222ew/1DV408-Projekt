<?php

class RegisterView
{
    private $cookieService;

    public function __construct()
    {
        $this->cookieService = new CookieService;
    }

    public function getUsername()
    {
        if(isset($_POST['regUsername']))
        {
            return trim($_POST['regUsername']);
        }

        return '';
    }

    public function getPassword()
    {
        if(isset($_POST['regPassword']))
        {
            return trim($_POST['regPassword']);
        }

        return '';
    }

    public function getRepeatedPassword()
    {
        if(isset($_POST['repRegPassword']))
        {
            return trim($_POST['repRegPassword']);
        }

        return '';
    }

    public function didRegister()
    {
        if(isset($_POST['register']))
        {
            $this->cookieService->save('inputUsername', $this->getUsername(), time()+60);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function register() {

        $username = $this->cookieService->load('inputUsername');

        //Replaces all invalid characters with '' and puts the remainder in input
        $username = preg_replace('/[^a-zåäöA-ZÅÄÖ0-9]/', '', $username);

        $body = "
				<a href='index.php' class='btn btn-lg btn-primary'>Tillbaka</a>
				<h2>Registrera användare</h2>
				<form action='?action=register' method='post'>
					<fieldset>
						<legend>Skriv in användarnamn och lösenord</legend>
						<label for='regUsername'>Username</label>
						<input type='text' id='regUsername' name='regUsername' value='$username'>
						<label for='regPassword'>Password</label>
						<input type='password' id='regPassword' name='regPassword'>
						<label for='repRegPassword'>Repeat password</label>
						<input type='password' id='repRegPassword' name='repRegPassword'>
						<button type='submit' name='register' class='btn btn-primary'>Registrera</button>
					</fieldset>
				</form>";

        return $body;
    }
}