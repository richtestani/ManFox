<?php

namespace RichTestani\ManFox\Traits;

use RichTestani\ManFox\ManFoxCache;

trait CacheTrait {

  public function getCache()
  {
    return new ManFoxCache([]);
  }

}

 ?>
