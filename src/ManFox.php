<?php

namespace RichTestani\ManFox;

use RichTestani\ManFox\Auth\OAuth;
use RichTestani\ManFox\Nodes;
use RichTestani\ManFox\API;
use GuzzleHttp\Client;
use RichTestani\ManFox\Auth\CreateClient;
use RichTestani\ManFox\ManFoxCache;
use RichTestani\ManFox\Tokens\AccessToken;
use Carbon\Carbon;
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

    if($credentials['store_id']) {
      $this->credentials['store_id'] = $credentials['store_id'];
    }
    $this->credentials['access_token'] = $this->session->get('access_token');
   
    $this->setEnvorinment();

    if( AccessToken::isExpired() ) {
      $this->refreshToken();
    } else {
      if($this->credentials['store_id']) {
        $customers = $this->store('customers', $this->api, $this);
        print_r($customers->response());
      } else {
        $this->home();
        $this->accountSetup($this->api->response());
      }
    }

    

  }

  public function home()
  {

    $this->api->setBearer($this->credentials['access_token']);
    $this->api->debug(true);
    $this->api->get('https://api.foxycart.com/');
    
  }

  public function accountSetup($home)
  {

    $stores = $home['_links']['fx:stores']['href'];
    $this->api->setBearer($this->credentials['access_token']);
    $this->api->debug(true);
    $this->api->get($stores);
 
  }


  public function __call($name, $options) 
  {
    $factory = new NodeFactory();

    $node = $factory->make($name, $this->api, $this)->get();
    return $node;
  }

  public function setEnvorinment()
  {

      AccessToken::session($this->session);
      $this->session->put('client_id', $this->credentials['client_id']);
      $this->session->put('client_secret', $this->credentials['client_secret']);
      $this->session->put('refresh_token', $this->credentials['refresh_token']);
      $this->session->put('access_token', $this->credentials['access_token']);
      $this->session->put('store_id', $this->credentials['store_id']);

  }

  public function refreshToken()
  {

    $this->api->debug(true);
    $this->api->post('https://api.foxycart.com/token', [
      'grant_type' => 'refresh_token',
      'refresh_token' => $this->credentials['refresh_token'],
      'client_id' => $this->credentials['client_id'],
      'client_secret' => $this->credentials['client_secret']
    ]);
    
    //get the response
    $response = $this->api->response();
    $expiration = Carbon::now()->addMinutes($response['expires_in']);

    //store the new token and expiration
    $this->session->put('access_token', $response['access_token']);
    $this->session->put('token_expiration', $expiration);

  }

}
 ?>
