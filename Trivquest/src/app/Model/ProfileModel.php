<?php

class ProfileModel
{
    private $notify;
    private $userRep;

    public function __construct(Notify $notify)
    {
        $this->notify = $notify;
        $this->userRep = new UserRepository();
    }

    public function getUserData($username)
    {
        $user = $this->userRep->getUserByName($username);

        return $user;
    }

    public function addRemoveTwo()
    {
        //TODO:Addremovetwo
    }

    public function addSkip()
    {
        //TODO:Addskip
    }

    public function removeGold()
    {
        //TODO:Removegold
    }


}