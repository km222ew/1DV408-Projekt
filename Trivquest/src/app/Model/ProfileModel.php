<?php

require_once("DAL/UserRepository.php");
require_once("User.php");

class ProfileModel
{
    private $notify;
    private $userRep;
    private $removeTwoPrice;
    private $skipPrice;
    private $removeTwoAmount;
    private $skipAmount;

    public function __construct(Notify $notify)
    {
        $this->notify = $notify;
        $this->userRep = new UserRepository();
        $this->removeTwoPrice = 250;
        $this->skipPrice = 500;
        $this->removeTwoAmount = 1;
        $this->skipAmount = 1;
    }

    public function getUserData($username)
    {
        $user = $this->userRep->getUserByName($username);

        return $user;
    }

    public function addRemoveTwo($username)
    {
        if($this->removeGold($username, $this->removeTwoPrice))
        {
            $this->userRep->updateUserRemoveTwo($username, $this->removeTwoAmount);
            $this->notify->success('You have successfully bought ('.$this->removeTwoAmount.') 50/50 for '.$this->removeTwoPrice.' gold.');
        }
        else
        {
            $this->notify->error("You don't have enough gold to buy a 50/50.");
        }
    }

    public function addSkip($username)
    {
        if($this->removeGold($username, $this->skipPrice))
        {
            $this->userRep->updateUserSkip($username, $this->skipAmount);
            $this->notify->success('You have successfully bought ('.$this->skipAmount.') Skip for '.$this->skipPrice.' gold.');
        }
        else
        {
            $this->notify->error("You don't have enough gold to buy a Skip.");
        }
    }

    private function removeGold($username, $cost)
    {
        $user = $this->getUserData($username);

        if($user->getGold() >= $cost)
        {
            $this->userRep->updateUserGold($username, -$cost);

            return true;
        }
        else
        {
            return false;
        }
    }


}