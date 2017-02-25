<?php
require_once('vendor/twitter-api/TwitterAPIExchange.php');
//requre_once('config.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "84282069-i0PRmyYUVgOk7JxaAXCCoBShawoY3c6kEM9ROBN63",
'oauth_access_token_secret' => "JDTQOlc4m8FLVFinkSQ8O76bIq3jYXPolaVVSckwoDzSt",
'consumer_key' => "Zzwn5YC9NqqlHnFzzXgANSzkh",
'consumer_secret' => "RvnYoviXYep7Q2tNzsZZnaeHaa7Eu5WcHzCRNz75fGPH2CvZ8U"
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = '?screen_name=b92vesti&count=2';
$twitter = new TwitterAPIExchange($settings);
$response_arr = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

if($response_arr["errors"][0]["message"] != "") {
    echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following "
    . "error message:</p><p><em>".
            $response_arr[errors][0]["message"]."</em></p>";
    exit();
}
echo "<pre>";
print_r($response_arr);
echo "</pre>";
