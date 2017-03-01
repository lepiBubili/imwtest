<?php
require_once('library/twitter-api/TwitterAPIEmbed.php');
require_once('entity/ErrorClass.php');
require_once('model/Mapper.php');

$settings = include('config.php');
$twitter = new TwitterAPIEmbed($settings);
$response = $twitter->getTweets();

if ($response instanceof ErrorClass) {
   echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following "
    . "error message:</p><p><em>".
            $response->message ."</em></p>";
    exit(); 
}

$mapper = new Mapper($settings);

foreach ($response as $tweet) {
   $tweet_id = $mapper->saveTweet($tweet);
   if ($tweet_id > 0) {
       echo "Tweet is being inserted. Date and time: " . date("Y-m-d H:i:s");
   } else {
       echo "Tweet is already in the database.";
   }
}

