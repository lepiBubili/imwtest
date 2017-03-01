<?php
require_once(__DIR__.'/../entity/User.php');
require_once(__DIR__.'/../entity/Tweet.php');
/**
 *
 * @package  model
 * @author   Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 */
class Mapper
{   
    protected $conn;
    
    /**
     * 
     * @param array $credentials - array of credentials that contain
     * @throws Exception in case if it is not possible to connect to the database
     */
    public function __construct(array $credentials)
    {
        $this->conn = new mysqli($credentials['db_host'], $credentials['db_username'] , 
                $credentials['db_password'], $credentials['db_name']);
        if (!$this->conn) {
          throw new Exception('Could not connect to database server!');
        } /*else {
          return $result;
        }*/
    }
    
    /**
     * @param Tweet $tweet - Tweet entity object to be saved
     * @return int
     * @throws Exception
     */
    public function saveTweet($tweet)
    {
        //tweet is already saved
        if ($this->fetchTweet($tweet->id_str)) {
           return 0; 
        }
        
        $cachedUser = $tweet->getUser();
        if (!($user = $this->fetchUser($cachedUser->id_str))) {
            $user_id = $this->saveUser($cachedUser);
            $tweet->user_id = $user_id;
        } else {
            $tweet->user_id = $user->id;
        }
        
        $date = new \DateTime($tweet->created_at);
        $created_at_formatted = $date->format("Y-m-d H:i:s");

        if (!$this->conn->query("INSERT INTO tweet (id_str, created_at, favorited,
            retweet_count, user_id, text) 
           VALUES ('". $tweet->id_str."', '". $created_at_formatted ."', '". $tweet->favorited
                ."', '" . $tweet->retweet_count . "', '" . $tweet->user_id . "', '" . $tweet->text . "')")) {
          throw new Exception('Tweet could not be inserted.');
        }
        
        return $this->conn->insert_id;
    }
    
    
    /**
     * @param User $user - User entity object to be saved
     * @return int
     * @throws Exception
     */
    public function saveUser($user)
    {
        if (!$this->conn->query("INSERT INTO user (id_str, name, profile_image_url,
            location, url, screen_name) 
           VALUES ('". $user->id_str."', '". $user->name ."', '". $user->profile_image_url
                ."', '" . $user->location . "', '" . $user->url . "', '" . $user->screen_name . "')")) {
          throw new Exception('User could not be inserted.');
        }
        
        return $this->conn->insert_id;
    }
    
    
    
    
    /**
     * 
     * @param type $id_str
     * @return \Tweet|boolean
     */
    public function fetchTweet($id_str)
    {
        $result = $this->conn->query("SELECT id, id_str, created_at, favorited,
            retweet_count, user_id, text 
            FROM tweet 
            WHERE id_str = '".$id_str."'");
        if (!$result) {
          return false;
        }

        $tweet = new Tweet();
        $row = $result->fetch_row();
        if (!(count($row) > 0)) {
            return false;
        } 
        $tweet->id = $row[0];
        $tweet->id_str = $row[1];
        $tweet->created_at = $row[2];
        $tweet->favorited = $row[3];
        $tweet->retweet_count = $row[4];
        $tweet->user_id = $row[5];
        $tweet->text = $row[6];

        $user = $this->fetchUserById($tweet->user_id);
        $tweet->setUser($user);
        
        
        return $tweet;
        
    }
    
    
    /**
     * 
     * @param string $id_str
     * @return false|\User
     */
    public function fetchUser($id_str)
    {
        $result = $this->conn->query("SELECT id, id_str, name, profile_image_url,
            location, url, screen_name 
            FROM user 
            WHERE id_str = '".$id_str."'");
        if (!$result) {
          return false;
        }
        
        $user = new User();
        $row = $result->fetch_row();
        if (!(count($row) > 0)) {
            return false;
        }
        $user->id = $row[0];
        $user->id_str = $row[1];
        $user->name = $row[2];
        $user->profile_image_url = $row[3];
        $user->location = $row[4];
        $user->url = $row[5];
        $user->screen_name = $row[6];

        return $user;
        
    }
    
    
    /**
     * 
     * @param string $id
     * @return false|\User
     */
    public function fetchUserById($id)
    {
        $result = $this->conn->query("SELECT id, id_str, name, profile_image_url,
            location, url, screen_name 
            FROM user 
            WHERE id = '".$id."'");
        if (!$result) {
          return false;
        }
        
        $user = new User();
        $row = $result->fetch_row();
        if (!(count($row) > 0)) {
            return false;
        }
        $user->id = $row[0];
        $user->id_str = $row[1];
        $user->name = $row[2];
        $user->profile_image_url = $row[3];
        $user->location = $row[4];
        $user->url = $row[5];
        $user->screen_name = $row[6];

        return $user;
        
    }
    
}


