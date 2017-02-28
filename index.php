<?php
require_once('library/twitter-api/TwitterAPIEmbed.php');
require_once('view/Header.php');
require_once('view/Footer.php');
require_once('view/TweetsView.php');
require_once('entity/ErrorClass.php');
//header settings
Header::instance()->createHeader();
$view = new TweetsView();
$settings = include('config.php');
$twitter = new TwitterAPIEmbed($settings);
$response = $twitter->getTweets();
if ($response instanceof ErrorClass) {
   echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following "
    . "error message:</p><p><em>".
            $response->message ."</em></p>";
    exit(); 
}

$view->showTweets($response);
Footer::instance()->createFooter();
