<?php

class ProfileView
{
    private $action;

    public function __construct()
    {
        $this->action = 'action';
    }

    public function didBuyRemoveTwo()
    {
        if (isset($_GET[$this->action]) && $_GET[$this->action] == 'buy=item=removetwo') {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function didBuySkip()
    {
        if (isset($_GET[$this->action]) && $_GET[$this->action] == 'buy=item=skip') {
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
                                    <h2><a href='?action=buy=item=removetwo' class='btn btn-lg btn-success'>Buy 1 for 250 Gold</a></h2>
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
                                    <h1><a href='?action=buy=item=skip' class='btn btn-lg btn-success'>Buy 1 for 500 Gold</a></h1>
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
                        <p>

                        </p>
                        <div class='text-center marginb'>
                            <a href='?action=".NavigationView::$actionPlay."' class='btn btn-lg btn-primary'>Start new round</a>
                        </div>
                    </div>
				</div>
                ";

        return $body;
    }
}