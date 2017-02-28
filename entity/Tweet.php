<?php
/**
 *
 * @package  entity
 * @author   Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 */
class Tweet
{   
    public $id;
    public $id_str;
    public $created_at;
    public $favorited;
    public $text;
    public $retweet_count;
    public $user_id;
    
    /**
     *
     * @var User
     */
    protected $user;
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
}

