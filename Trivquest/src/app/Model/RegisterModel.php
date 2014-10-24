<?php

require_once("DAL/UserRepository.php");
require_once("User.php");

class RegisterModel
{
    private $notify;
    private $userRep;

    public function __construct(Notify $notify)
    {
        //Notifications notify->success/error/info(message, optional header)
        $this->notify = $notify;
        $this->userRep = new UserRepository();
    }

    //Make sure provided credentials are valid for registration
    public function validateRegister($username, $password, $repPassword)
    {
        $validChars = '/[^a-zåäöA-ZÅÄÖ0-9]/';
        $clearForRegistration = true;

        if($password != $repPassword)
        {
            $clearForRegistration = false;
            $this->notify->error('Lösenorden matchar inte');
        }

        if(strlen($username) < 3)
        {
            $clearForRegistration = false;
            $this->notify->error('Användarnamnet har för få tecken. Minst 3 tecken');
        }

        if(strlen($password) < 6)
        {
            $clearForRegistration = false;
            $this->notify->error('Lösenorden har för få tecken. Minst 6 tecken');
        }

        //Check if username contains invalid characters
        if(preg_match($validChars, $username))
        {
            $clearForRegistration = false;
            $this->notify->error('Användarnamnet innehåller ogiltiga tecken');
        }

        //Check if username exist in database
        if(strlen($username) > 0 && $this->userRep->getUserByName($username) != null)
        {
            $clearForRegistration = false;
            $this->notify->error('Användarnamnet är redan upptaget');
        }

        //Input user into database if everything is ok
        if($clearForRegistration)
        {
            $this->registerUser(new User($username, $password, null, null, null, null, null, null, null, null));

            $this->notify->success('Registrering av ny användare lyckades');
            return true;
        }

        return false;
    }

    private function registerUser(User $user)
    {
        $this->userRep->addUser($user);
    }
}