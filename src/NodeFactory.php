<?php

namespace RichTestani\ManFox;

use RichTestani\ManFox\Nodes\{
  Categories,
  Client,
  Coupon,
  CouponCodes,
  Coupons,
  Store,
  Stores,
  Customers,
  PropertyHelpers
};


class NodeFactory
{

  protected $node;

  public function make($factory, $api, $manfox)
  {

    $this->$factory($api, $manfox);
    return $this;
  }

  public function get()
  {
    return $this->node;
  }

  private function store($api, $manfox)
  {
    $this->node = new Store($api, $manfox);
  }

  private function stores($api, $manfox)
  {
    $this->node = new Stores($api, $manfox);
  }

  private function customers($api, $manfox)
  {
    $this->node = new Customers($api, $manfox);
  }

  private function propertyHelpers($api, $manfox)
  {
    $this->node = new PropertyHelpers($api, $manfox);
  }

  private function client($api, $manfox)
  {
    $this->node = new Client($api, $manfox);
  }


}
