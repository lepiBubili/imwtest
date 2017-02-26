<?php
require_once('TwitterAPIExchange.php');
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
    
    
    public function get()
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
        
        $this->twitterApiExchange->setGetfield($getfield);
    }
    
    
}
