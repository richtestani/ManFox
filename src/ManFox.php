<?php

namespace RichTestani\ManFox;

use RichTestani\ManFox\Auth\OAuth;
use RichTestani\ManFox\Nodes;
use RichTestani\ManFox\API;
use GuzzleHttp\Client;
use RichTestani\ManFox\Auth\CreateClient;
use RichTestani\ManFox\ManFoxCache;
use RichTestani\ManFox\Tokens\AccessToken;
use RichTestani\ManFox\Drivers\{
  Sessions
};

/*
The initializing file to work with this package.

$mf = new ManFox\ManFox($config);

//return your coupons
$mf->coupons();

//return single coupon
$mf->coupon('big deal coupon');
*/

class ManFox {

  protected $api;

  protected $response;

  protected $status;

  protected $credentials;

  protected $config;

  protected $auth = null;

  protected $is_authed;

  public function __construct($credentials, $debug = 0)
  {

    $this->debug = $debug;

    $this->api = new API();

    $this->session = Sessions::load('php');

    $this->credentials = $credentials;

    $home = $this->api->get('https://api.foxycart.com/');
    var_dump($home);

  }


  public function home() 
  {
    $factory = new NodeFactory();

    $node = $factory->make($name, $this->api, $this)->get();
    return $node;
  }

  public function setEnvorinment()
  {

  }

}
 ?>
