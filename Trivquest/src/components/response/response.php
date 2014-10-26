<?php
//Sends out html for the client
class Response
{
	//Renders html page
	public function HTMLPage($body, $notifyView)
    {
		if ($body === NULL)
        {
			throw new Exception('HTMLView::echoHTML does not allow body to be null');
		}

		$notifications = '';

		//Don't fetch notifications on post, these pages should never be shown
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
			$notifications = $notifyView->showAll();
		}

		echo "
			<!DOCTYPE html>
			<html>
			<head>
				<title>1dv408, l2-login</title>
				<meta charset='utf-8'>
				<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
				<link rel='stylesheet' href='style/style.css'>
			</head>
			<body>
                <div class='container'>
                    <div class='page-header'>
                      <h1>Welcome to Trivquest</h1>
                      <h3>Test your knowledge...</h3>
                    </div>
                    $notifications
                    $body
				    <br />
                    <div class='text-center marginb'>
                        <h5>Application created by Kevin Madsen</h5>
                    </div>
				    <hr>
				</div>
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
			</body>
			</html>";
	}
}