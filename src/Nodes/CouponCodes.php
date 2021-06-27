<?php

namespace RichTestani\ManFox\Nodes;

/**

Node: CouponCodes

Relations: store/coupons/coupon/coupon_codes

This collects all coupon codes for a single coupon. You can test if a code was used,
return the number of times used

*/

use RichTestani\ManFox\Contracts\iNode;
use RichTestani\ManFox\Nodes;
use Illuminate\Support\Collection;

class CouponCodes extends Nodes implements iNode {

  public function __construct($api, $link)
  {
    $this->api = $api;
    $codes = $this->api->get($link);
    $this->codes = new Collection($codes);
  }

  public function code($code)
  {

  }

  public function numTimesUsed()
  {

  }

  public function hasBeenUsed()
  {

  }
}

 ?>
