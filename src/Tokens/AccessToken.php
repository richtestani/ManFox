<?php

namespace RichTestani\ManFox\Tokens;

use Carbon\Carbon;
use RichTestani\ManFox\Contracts\iSessions;

class AccessToken
{

  static $token;

  static $expired;

  static $expires_at;

  static $session;

  static public function session(iSessions $session)
  {
    self::$session = $session;
  }

  static public function put($token)
  {
    self::$expires_at = Carbon::now()->addHours(2);
    self::$session->put('token_expiration', self::$expires_at);
    self::$session->put('manfox_access_token', $token);

    self::$token = $token;
  }

  static public function get()
  {
    if(self::hasToken()) {
      self::$token = self::$session->get('manfox_access_token');
    }
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