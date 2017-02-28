<?php
/**
 *
 * @package  view
 * @author   Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 */
class TweetsView
{    
    public function showTweets(array $tweets)
    {
?>
    <ul>
<?php
        foreach ($tweets as $tweet)
        {
            $date = new \DateTime($tweet->created_at);
            $date_formatted = $date->format("F j, Y, g:i a");
?>
        <li>
          <img src="<?php echo $tweet->getUser()->profile_image_url;?>" 
               height="48" width="48" style="float:left;margin-right: 10px;" />
        <div><span style="font-weight: bold;"><?php echo $tweet->getUser()->name; ?>
            </span>
            <a href="<?php echo $tweet->getUser()->url;?>" style="text-decoration: none;">
                <span style="color:grey;">
                <?php  echo " @" . $tweet->getUser()->screen_name; ?>
                </span>
            </a>
            <span style="font-family:Arial; font-style: italic;font-size: 16px;">
                <?php echo " " . $date_formatted; ?></span>
        </div>
          <?php echo $tweet->text;?>
        </li>
<?php
        }
?>
    </ul>
<?php
    }
}
