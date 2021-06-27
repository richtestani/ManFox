<?php

namespace RichTestani\ManFox\Responses;

abstract class StandardResponse
{

  protected $response;

  public function put($response)
  {
    $this->response = $response;
  }
  public function get()
  {
    return $this->response;
  }
  public function isEmpty()
  {
    return (is_null($this->response) || empty($this->response)) ? true : false;
  }
  public function found()
  {
    return count($this->response);
  }
  public function links($key='')
  {
    return $this->response[$key];
  }

}
 ?>
