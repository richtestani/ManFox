<?php

namespace RichTestani\ManFox\Nodes;

use RichTestani\ManFox\Contracts\iNode;
use Illuminate\Support\Collection;
use RichTestani\ManFox\Nodes;
use RichTestani\ManFox\ManFoxCache;
use RichTestani\ManFox\Models\Store as ManFoxStore;
use Carbon\Carbon;

class Client extends Nodes implements iNode
{

  public function __construct($api, $credentials)
  {
    $this->api = $api;
    echo 'new client';
  }

  public function test()
  {
    
  }

}
