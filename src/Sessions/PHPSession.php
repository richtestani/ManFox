<?php

namespace RichTestani\ManFox\Sessions;

if(!isset($_SESSION)) {
     session_start();
}

use RichTestani\ManFox\Contracts\iSessions;


class PHPSession implements iSessions
{

  public function put($name, $value)
  {
    $_SESSION[$name] = $value;
  }

  public function get($name)
  {
    if($this->has($name)) {
      return $_SESSION[$name];
    }

    return null;
  }

  public function has($name)
  {
    return (array_key_exists($name, $_SESSION)) ? true : false;
  }

  public function forget($name)
  {
    unset($_SESSION[$name]);
  }

}

 ?>
