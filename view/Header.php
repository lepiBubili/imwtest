<?php
/**
 * Singleton class for header
 * 
 * 
 * @package view
 * @author Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 *
 */
final class Header
{
    /**
     * Call this method to get singleton
     *
     * @return Header
     */
    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Header();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {

    }
    
    
    public function createHeader()
    {
?>
        <!DOCTYPE html>
        <html>
          <head>
            <title><?php echo "Tweets"?></title>
            <style>
              body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 28px
              }
              ul{
                list-style-type: none;
              }
              li, td {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 20px;
                border-bottom: 1px solid gray;
                padding: 5px;
                min-height: 50px;
              }
              hr { color: #3333cc;
                width=300;
                text-align=left}
              a {
                color: #000000
              }
            </style>
          </head>
          <body>
          <div style="margin:auto;width:600px;">
            <h1>Tweets</h1>
          </div>
          <hr />
          <div style="margin:auto;width:40%;">
<?php

    }
}


