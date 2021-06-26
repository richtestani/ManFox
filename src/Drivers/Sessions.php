<?php

namespace RichTestani\ManFox\Drivers;

class Sessions {

  static public function load($driver)
  {
    //see if session has already been initiated
    if( session_status() !== 2 ) {
      session_start();
    }

    if(method_exists(get_called_class(), $driver)) {
      return self::$driver();
    }
  }

  static public function php()
  {
    return new \RichTestani\ManFox\Sessions\PHPSession();
  }

}
 ?>
