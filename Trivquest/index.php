<?php

session_set_cookie_params(0);
session_start();

require_once('src/components/response/response.php');
require_once('src/components/notify/notify.service.php');
require_once('src/components/notify/notify.view.php');
require_once('src/components/notify/notification.php');
require_once('src/app/Controller/NavigationController.php');

$response = new Response();
$notify = new Notify();
$notifyView = new NotifyView($notify);

$navigationController = new NavigationController();

$response->HTMLPage($navigationController->doControl($notify), $notifyView);

//$response->HTMLPage($controller->index(), $notifyView);