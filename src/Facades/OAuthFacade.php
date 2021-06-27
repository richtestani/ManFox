<?php

namespace RichTestani\ManFox\Facades;


use Illuminate\Support\Facades\Facade;

class OAuthFacade extends Facade {

  protected static function getFacadeAccessor()
  {
      return 'OAuth';
  }

}

 ?>
