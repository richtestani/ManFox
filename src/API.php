<?php

namespace RichTestani\ManFox;

use GuzzleHttp\Client;

/*
The initializing file to work with this package.

$mf = new ManFox\ManFox($config);

//return your coupons
$mf->coupons();

//return single coupon
$mf->coupon('big deal coupon');
*/

class API {

  protected $api;

  protected $http;

  protected $auth;

  protected $request;

  protected $response;

  protected $configuration;

  protected $debug = false;

  protected $uri;
  
  protected $headers;
  
  protected $form_data;

  public function __construct()
  {

    $this->http = new Client(
      [
        'defaults' =>
        ['debug' => false,
        'exceptions' => false]
      ]
    );


    // $credentials = $this->auth->getCredentials();
    // $bearer = $credentials['token'];
    $this->configuration = [
      'headers' => [
        'FOXY-API-VERSION' => 1
      ]
    ];

  }


  public function post($url, $options = [])
  {
    
    if(!empty($options)) {
      $this->buildFormData($options);
    }
    if(empty($url) || is_null($url)) {
      die('request url is empty');
    }

    $this->request('post', $url, $this->configuration);
  }

  /**
   * 
   * 
   * Get Requests
   * =========================
   * $url @string
   * 
   * $options @array
   * 
   */
  public function get($url, $options = [])
  {

    if(!empty($options)) {

      $this->buildFormData($options);

    }
    
  
    $this->request('get', $url);

  }

  public function patch($url, $options = [])
  {

    if(!empty($options)) {

      $this->buildFormData($options);

    }
	
    $this->request('patch', $url);

  }

  private function request($method, $url, $options = [])
  {

    $this->uri = $url;
    
    $options = array_merge($options, $this->configuration);
    
    if($this->debug) {
      $this->debugOptions($options);
      $this->showProperties();
      $this->showSessions();
    }
    
    $this->response = $this->http->$method($url, $options);
  }

  public function response()
  {
    return json_decode($this->response->getBody(), true);
  }

  public function setHeader($name, $value)
  {
    $this->configuration['headers'][$name] = $value;
  }

  public function setBearer($token)
  {
    $this->setHeader('Authorization', 'Bearer ' . $token);
  }

  public function addFormParam($name, $value)
  {
    $this->configuration['form_params'][$name] = $value;
  }

  private function buildFormData($data)
  {
    foreach($data as $k => $d) {

      $this->addFormParam($k, $d);

    }

  }

  public function debug($mode = false)
  {

    $this->debug = $mode;

  }
  public function debugOptions($options)
  {
    echo '<pre>';
    print_r($this->configuration);
    echo '</pre>';
  }

  public function debugResponse()
  {
    echo '<pre>';
    print_r($this->response());
    echo '</pre>';
  }

  public function showProperties()
  {
    echo '<pre>';
    echo $this->uri.'<br>';
    echo '</pre>';
  }

  public function showSessions()
  {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
  }

}
 ?>
