<?php

namespace RichTestani\ManFox;

use RichTestani\ManFox\Links;
use RichTestani\ManFox\Crud\ {
  Create,
  Update,
  Delete,
  Read
};
use RichTestani\ManFox\ManFoxCache;
use RichTestani\ManFox\Contracts\iResponse;
use RichTestani\ManFox\Responses;
use RichTestani\ManFox\Drivers\{
  Sessions
};

abstract class Nodes
{

  use \RichTestani\ManFox\Traits\CacheTrait;

  protected $store_id;

  protected $links;

  protected $base_param;

  protected $url_params;

  protected $form_params;

  protected $uri;

  protected $session;

  public function setLinks($links)
  {
    $this->links = new Links($links['_links']);
  }

  public function getLink($name)
  {
    $item = $this->links->get($name);
    return $item['href'];

  }

  protected function handleResponse(iResponse $response, $data = '')
  {
    if(empty($data)) {
      $data = $this->api->response();
    }
    $response->put($data);
    return $response;
  }

  public function get($endpoint, $options)
  {
    $responseClass = $this->resolveResponseClass(get_called_class());
    $responseClass = "RichTestani\\ManFox\\Responses\\".$responseClass;
    return $this->handleResponse( new $responseClass() );
  }

  public function crud($mode, $endpoint, $data = [])
  {

    switch($mode) {
      case 'create':
        $crud = new Create($this->api, $endpoint, $data);
      break;

      case 'update':
        $crud = new Update($this->api, $endpoint, $data);
      break;

      case 'read':
        $crud = new Read($this->api, $endpoint, $data);
      break;

      case 'delete':

      break;
    }

    return $crud->response();

  }

  private function resolveResponseClass($class)
  {
    $parts = explode("\\", $class);
    $name = end($parts).'Response';
    return $name;
  }

}
