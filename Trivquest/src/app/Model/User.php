<?php

//So many gets....
class User
{
    private $username;
    private $password;
    private $token;
    private $expire;
    private $gold;
    private $skip;
    private $removeTwo;
    private $exp;
    private $expToNextLevel;
    private $level;

    public function __construct($username, $password, $token, $expire, $gold, $skip, $removeTwo, $exp, $expToNextLevel, $level)
    {
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
        $this->expire = $expire;
        $this->gold = $gold;
        $this->skip = $skip;
        $this->removeTwo = $removeTwo;
        $this->exp = $exp;
        $this->expToNextLevel = $expToNextLevel;
        $this->level = $level;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getExpire()
    {
        return $this->expire;
    }

    public function getGold()
    {
        return $this->gold;
    }

    public function getSkip()
    {
        return $this->skip;
    }

    public function getRemoveTwo()
    {
        return $this->removeTwo;
    }

    public function getExp()
    {
        return $this->exp;
    }

    public function getExpToNextLevel()
    {
        return $this->expToNextLevel;
    }

    public function getLevel()
    {
        return $this->level;
    }
}