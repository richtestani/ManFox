<?php

namespace RichTestani\ManFox\Nodes;

/**

Node: Coupon
Represents a single coupon definition

Relations: store/coupons/coupon

Usage:
$coupon = $api->store()->coupons('my coupon name');

Simply pass the name of the coupon as the single argument

*/

 use RichTestani\ManFox\Contracts\iNode;
 use RichTestani\ManFox\Nodes;
 use Illuminate\Support\Collection;

class Coupon extends Nodes implements iNode {

  protected $codes;

  public function __construct($api, $coupon)
  {
    $this->api = $api;
    $this->coupon = new Collection ($coupon);
    $this->collection = new Collection($this->coupon);
    $this->links();

    $this->codes = new CouponCodes($this->api, $this->getLink('fx:coupon_codes'));
  }

  public function discountType()
  {
    return $this->coupon->get('coupon_discount_type');
  }

  public function isDiscountType($type) {

    return $this->discountType() == $type;

  }

  public function usesPerCode()
  {
    return $this->collection->get('number_of_uses_allowed_per_code');
  }

  public function usesPerCustomer()
  {
    return $this->collection->get('number_of_uses_allowed_per_customer');
  }

  public function usesAllowed()
  {
    return $this->collection->get('number_of_uses_allowed');
  }

  public function usesToDate()
  {
    return $this->collection->get('number_of_uses_to_date');
  }
}

 ?>
