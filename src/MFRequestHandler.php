<?php

namespace RichTestani\ManFox;

use Illuminate\Http\Request;

class MFRequestHandler {

  protected $nodes;

  public function __construct()
  {

    $this->request = new MFRequest();

    if( strtolower(request()->method()) == 'get') {
      $this->request->get(request()->url());
    } else {
      $this->request->post(request()->post());
    }

    //get available nodes
    $nodes = scandir(__DIR__.'/Nodes');
    foreach($nodes as $k => $n) {
      if($this->isDot($n)) {
        unset($nodes[$k]);
      } else {
        $nodes[$k] = str_replace('.php', '', $n);
      }
    }

    $this->nodes = $nodes;

  }

  private function isDot($segment)
  {
    return ('.' == $segment || '..' == $segment) ? true : false;
  }

  private function isValidNode($node)
  {
    if(in_array($this->nodes, $node)) {

    }
  }

  public function __call($method, $args)
  {

    extract($args);


    switch($method) {

      case 'get':
        $response = $this->request->get($url, $args);
        break;

      case 'post':
        $response = $this->request->post($url, $args);
    }
  }

}

 ?>
