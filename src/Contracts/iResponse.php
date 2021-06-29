<?php

namespace RichTestani\ManFox\Contracts;

interface iResponse {
  public function isEmpty();
  public function found();
  public function get();
  public function put($response);
  public function links($key='');
}
 ?>
