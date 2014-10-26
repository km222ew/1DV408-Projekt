<?php

class ProfileView
{
    private $action;
    private $buyRemoveTwo;
    private $buySkip;

    public function __construct()
    {
        $this->action = 'action';
        $this->buyRemoveTwo = 'buy=item=removetwo';
        $this->buySkip = 'buy=item=skip';
    }

    public function didBuyRemoveTwo()
    {
        if (isset($_GET[$this->action]) && $_GET[$this->action] == $this->buyRemoveTwo)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function didBuySkip()
    {
        if (isset($_GET[$this->action]) && $_GET[$this->action] == $this->buySkip)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function renderProfile($username, $level, $exp, $expToNextLevel, $removeTwo, $skip, $gold)
    {
        $body = "<div class='row row-eq-height'>
                    <div class='col-lg-5 marginr bc'>
                        <div class='text-center'>
                            <h1><a href='?action=".NavigationView::$actionShowProfile."'>Profile</a></h1>
                        </div>
                        <h2 class='text-center'>$username</h2>
                        <h3 class='text-center'>Level : $level</h3>
                        <h4 class='text-center'>Exp : $exp/$expToNextLevel</h4>

                        <br>

                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='text-left'>
                                    <h2><span class='label label-info'>50/50 x $removeTwo</span></h2>
                                </div>
                            </div>
                            <div class='col-lg-6'>
                                <div class='text-center'>
                                    <div class='text-right'>
                                    <h2><a href='?action=$this->buyRemoveTwo' class='btn btn-lg btn-success'>Buy 1 for 250 Gold</a></h2>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-lg-6'>
                                <div class='text-left'>
                                    <h2><span class='label label-info'>Skip x $skip</span></h2>
                                </div>
                            </div>
                            <div class='col-lg-6'>
                                <div class='text-center'>
                                    <div class='text-right'>
                                    <h1><a href='?action=$this->buySkip' class='btn btn-lg btn-success'>Buy 1 for 500 Gold</a></h1>
                                </div>
                                </div>
                            </div>
                        </div>

                        <h2><span class='label label-default'>Gold : $gold</span></h2>

                        <br>
                        <div class='text-center marginb'>
                            <a href='?action=".NavigationView::$actionLogout."' class='btn btn-lg btn-primary'>Sign out</a>
                        </div>
				    </div>

                    <div class='col-lg-7 bc'>
                    <h1 class='text-center'>Instructions</h1>
                    <h4>
                        <ul>
                            <li class='marginb'>View your current statistics here in the profile</li>
                            <li class='marginb'>Start a new trivia by clicking the button down below</li>
                            <li class='marginb'>You can buy more lifelines to the right. Simply click the buy button for the corresponding lifeline. Just make sure you have enough gold</li>
                            <li class='marginb'>If you encounter a tough question, make use of a lifeline if you have one. 50/50 removes 2 wrong answers from play and gives you a 50/50 chance of answering correct.
                            The Skip lifeline skips a question and treats it as if you answered it correctly, neat huh?</li>
                            <li class='marginb'>If you answer a question wrong there will be a penalty! Don't worry though, answering a question correctly nets you double what you lost!</li>
                            <li class='marginb'>However if you make it through a trivia you can expect a bonus in the end, based on your performance of course.</li>
                            <li class='marginb'>Each time you answer a question wrong you lose a life. You have 5 lives each trivia, make them count!</li>
                        </ul>
                    </h4>
                        <div class='text-center paddingt marginb'>
                            <a href='?action=".NavigationView::$actionNewRound."' class='btn btn-lg btn-primary'>Start new trivia</a>
                        </div>
                    </div>
				</div>
                ";

        return $body;
    }
}