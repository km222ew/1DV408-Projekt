<?php

require_once('src/app/View/ProfileView.php');
require_once('src/app/Model/ProfileModel.php');

class ProfileController
{
    private $profileView;
    private $profileModel;

    public function __construct(Notify $notify)
    {
        $this->profileView = new ProfileView();
        $this->profileModel = new ProfileModel($notify);
    }

    public function buyRemoveTwo($username)
    {

    }

    public function buySkip($username)
    {

    }

    public function showProfile($username)
    {
        $user = $this->profileModel->getUserData($username);

        if($this->profileView->didBuyRemoveTwo())
        {
            $this->buyRemoveTwo($username);
        }

        if($this->profileView->didBuySkip())
        {
            $this->buySkip($username);
        }

        return $this->profileView->renderProfile($user->getUsername(), $user->getLevel(), $user->getExp(),
                                                 $user->getExpToNextLevel(), $user->getRemoveTwo(), $user->getSkip(),
                                                 $user->getGold());

    }
}