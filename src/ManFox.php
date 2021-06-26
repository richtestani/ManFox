<?php

namespace RichTestani\ManFox;

// use RichTestani\ManFox\Auth\OAuth;
// use RichTestani\ManFox\Nodes;
use RichTestani\ManFox\API;
use GuzzleHttp\Client;
// use RichTestani\ManFox\Auth\CreateClient;
// use RichTestani\ManFox\ManFoxCache;
// use RichTestani\ManFox\Tokens\AccessToken;
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

    print_r($credentials);

    // $this->config = require_once(__DIR__.'/configuration.php');

    $this->session = Sessions::load('php');

    // $this->session->forget('access_token');

    // $this->credentials = $credentials;


    // AccessToken::session($this->session);

    // if( !AccessToken::hasToken() || AccessToken::isExpired() ) {

    //   $this->is_authed = false;

    //   //update token
    //   if(AccessToken::hasToken()) {

    //     unset($this->credentials['access_token']);

    //   }

    //   $this->auth = new OAuth($this->credentials, $this->session);
    //   $this->auth->refreshToken();
    //   $this->is_authed = true;

    // } else {

    //   $this->is_authed = true;

    // }


  }

  /**
   * Use this to run manfox client.
   * If no client is configured, one will be created.
   *
   * @param  array  $credentials
   * @return mixed
   */
  public function start()
  {

    if(!empty($credentials['client_id'])) {

      $this->credentials = $credentials;

    }

    if($this->is_authed) {
      $token = AccessToken::get();
      $this->credentials['access_token'] = $token;
      $this->api->setHeader('Authorization', 'Bearer '.$token);
    }
  }

  /**
   * Returns the current status of manfox
   *
   * @param  array  $credentials
   * @return string
   */
  public function status()
  {
    return $this->status;
  }

  public function __call($name, $args)
  {

    $factory = new NodeFactory();

    $node = $factory->make($name, $this->api, $this)->get();
    return $node;

  }

  public function session()
  {
    return $this->session;
  }

  public function authorize($redirect = '')
  {

    if(is_null($this->auth)) {
      $this->auth = new OAuth($this->credentials, $this->session, $redirect, 1);
    }

    //$this->debug();

    if(!$this->auth->hasCode()) {
  
        //initialize
        $this->session->forget($this->auth->getAuthSessionName());
        $url = $this->auth->getAuthUrl();

        //write auth state
        $this->session->put($this->auth->getAuthSessionName(), $this->auth->getState());

        //send to authoze endpoint
        header("Location:".$url.'&scope=store_full_access');

      } else if( $this->auth->hasState() && $this->auth->stateMatches($this->auth->getState())) {
        //bad

      } else {
        //good
        $this->auth->accessToken('authorization_code', ['code' => $_GET['code']] );
        $token = AccessToken::get();

        //get store
        $this->api->setHeader('Authorization', 'Bearer '.$token);
        $result = $this->api->get();
        //save this store for reuse.
        return $result;
      }

  }

  public function getSession()
  {
    return $this->session;
  }

  public function debug()
  {
    echo '<pre>';
    var_dump($this->auth);
    die();
  }

}
 ?>
