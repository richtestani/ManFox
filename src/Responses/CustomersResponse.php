<?php

namespace RichTestani\ManFox\Responses;

use RichTestani\ManFox\Contracts\iResponse;

class CustomersResponse extends StandardResponse implements iResponse
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
    if(count($this->response['_embedded']['fx:customers']) == 0) {
      return null;
    }
    return $this->response['_embedded']['fx:customers'][0];
  }

}
 ?>
