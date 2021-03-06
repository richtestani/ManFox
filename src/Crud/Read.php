<?php

namespace RichTestani\ManFox\Crud;

use RichTestani\ManFox\Contracts\iCrud;
use RichTestani\ManFox\Contracts\iService;
use RichTestani\ManFox\Nodes;

class Read implements iCrud {

  protected $api;

  protected $node;

  public function __construct($api, $endpoint, $data)
  {
    $this->api = $api;
    $this->exec($endpoint, $data);
  }

  public function exec($endpoint, $data)
  {
    $this->api->get($endpoint, $data, true);
  }

  public function response()
  {
    return $this->api->response();
  }

}
 ?>
