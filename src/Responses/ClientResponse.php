<?php

namespace RichTestani\ManFox\Responses;

use RichTestani\ManFox\Contracts\iResponse;

class ClientResponse extends StandardResponse implements iResponse
{


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
    return (empty($this->response)) ? true : false;
  }
  public function found()
  {
    return count($this->response);
  }
  public function links($key='')
  {
    return $this->response[$key];
  }

  public function first()
  {
    return $this->response;
  }

}
 ?>
