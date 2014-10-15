<?php

class NavigationView
{
    private static $action = "action";

    public static $actionShowProfile = "profile";
    public static $actionLogout = "logout";
    public static $actionRegister = "register";
    public static $actionPlay = "play";
    public static $actionSubmitAnswer = "answer";

    public static function getAction()
    {
        if(isset($_GET[self::$action]))
        {
            return $_GET[self::$action];
        }

        return self::$actionShowProfile;
    }
}