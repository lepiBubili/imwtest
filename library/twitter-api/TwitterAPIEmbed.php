<?php
require_once('TwitterAPIExchange.php');
require_once(__DIR__.'/../../entity/ErrorClass.php');
require_once(__DIR__.'/../../entity/Tweet.php');
require_once(__DIR__.'/../../entity/User.php');
/**
 * Twitter API Embed : Class that configures connection and realises 
 * API calls for the v1.1 API extending Twitter-API-Exchange wrapper
 *
 * @package  Twitter-API
 * @author   Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 */
class TwitterAPIEmbed extends TwitterAPIExchange
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT  = 'PUT';
    
    
    /**
     *
     * @var string
     * url GET for v1.1 Twitter API
     */
    protected $urlGet = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    
    
    /**
     *
     * @var array
     */
    protected $credentials;



    /**
    * Creates TwitterAPIExchange object wrapper and sets it as a property. Credentials
    * contain oauth- and consumer keys and screen name and count of tweets as well
    * @param array $credentials
    */
    public function __construct(array $credentials)
    {
        parent::__construct($credentials);
        $this->credentials = $credentials;   
    }
    
    
    /**
     * 
     * @return \Error|array
     */
    public function getTweets()
    {
        $getfield = '';
        if (!empty($this->credentials['screen_name']) && !empty($this->credentials['count'])) {
            $getfield = '?screen_name=' . $this->credentials['screen_name']. '&count=' 
                    . $this->credentials['count'];
        } elseif (!empty($this->credentials['screen_name'])) {
            $getfield = '?screen_name=' . $this->credentials['screen_name']; 
        } elseif (!empty($this->credentials['count'])) { //in this case twitter api will return tweets from the page of registered developer
            $getfield = '?count=' . $this->credentials['count'];
        }
        
        $response_arr = json_decode($this->setGetfield($getfield)
            ->buildOauth($this->urlGet, self::GET)
            ->performRequest(),TRUE);
        
        if(isset($response_arr["errors"]) && !empty($response_arr["errors"][0]["message"])) {
            return new ErrorClass(400, $response_arr["errors"][0]["message"] );
        }
        
        $tweets = [];
        
        foreach ($response_arr as $response) {
            $tweet = new Tweet();
            $tweet->id_str = $response['id_str'];
            $tweet->created_at = $response['created_at'];
            $tweet->favorited = $response['favorited'];
            $tweet->retweet_count = $response['retweet_count'];
            $tweet->text = $response['text'];
            
            $user = new User();
            $user->id_str = $response['user']['id_str'];
            $user->name = $response['user']['name'];
            $user->profile_image_url = $response['user']['profile_image_url'];
            $user->location = $response['user']['location'];
            $user->url = $response['user']['url'];
            $user->screen_name = $response['user']['screen_name'];
            
            $tweet->setUser($user);
            
            $tweets[] = $tweet;
        }
        
        return $tweets;
    }
    
    
}
