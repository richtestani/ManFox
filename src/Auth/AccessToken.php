<?php

namespace RichTestani\ManFox\Auth;

use Carbon\Carbon;
use RichTestani\ManFox\Sessions\PhpSessions;

class AccessToken
{

  static $token = null;

  static $expired;

  static $expires_at;

  static $session;

  static public function session(PhpSessions $session)
  {
    self::$session = $session;
  }

  static public function put($token)
  {
    self::$session->forget('manfox_access_token');
    self::$expires_at = Carbon::now()->addHours(2);
    self::$session->put('token_expiration', self::$expires_at);
    self::$session->put('manfox_access_token', $token);

    self::$token = $token;
  }

  static public function get()
  {

    if(!self::hasToken()) {

      return null;

    }

    self::$token = self::$session->get('manfox_access_token');
    return self::$token;

  }

  static public function hasToken()
  {

    if(self::$session->has('manfox_access_token')) {
      return true;
    } else {
      return false;
    }
  }

  static public function isExpired()
  {
    if(self::$session->get('token_expiration') < Carbon::now()) {
      return true;
    } else {
      return false;
    }
  }

}

 ?>
