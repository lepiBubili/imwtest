<?php
/**
 * Singleton class for footer
 * 
 * @package view
 * @author Ljubisa Stojanovic <ljdstojanovic@gmail.com>
 *
 */
final class Footer
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
            $inst = new Footer();
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
    
    
    public function createFooter() {
  // print an HTML footer
?> 
        </div>
        <hr />
        </body>
        </html>
<?php
    }

}



