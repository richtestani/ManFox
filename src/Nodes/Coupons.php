<?php

 namespace RichTestani\ManFox\Nodes;

 use RichTestani\ManFox\Contracts\iNode;
 use Illuminate\Support\Collection;
 use RichTestani\ManFox\Nodes;
 use RichTestani\ManFox\ManFoxCache;
 use RichTestani\ManFox\Models\Store as ManFoxStore;
 use Carbon\Carbon;

 class Coupons extends Nodes implements iNode
 {

   use \RichTestani\ManFox\FoxyOptionsTrait;

   protected $url = '';

   protected $store_id;

   protected $store_links;

   public $collection;

   public $coupons_expiration;

   public $coupon_expiration;

   protected $coupon;


   /*
    A collection of coupons
   */
   public $coupons = null;

   /*
   A collection of CouponCodes objects
   */
   public $codes;

   public function __construct($api, $link)
   {
     $this->api = $api;

     $this->setLimit(100);

     $result = $this->api->get($link.$this->buildOptions());

     $this->collection = new Collection($result);

     $this->links();

     $this->cache = $this->getCache();

     $this->coupons = $this->cache->get('coupons');

     //fetch collection from FoxyCart API
     if(is_null($this->coupons)) {

       $this->coupons = new Collection( $this->collection->get('_embedded')['fx:coupons'] );

       $expir = Carbon::now();

       $expir->addHours(12);

       $this->cache->store('coupons', $this->coupons, $expir);

     }

   }

   public function coupon($name)
   {

     $key = str_replace(' ', '_', strtolower($name));

     if($this->cache->has($key) )  {

       $coupon = $this->cache->get($key);

       $coupon = new Coupon($this->api, $coupon);
       return $coupon;
     }

     $coupon =  $this->coupons->filter( function($array) use ($name) {

         if($array['name'] == $name) {

           $key = str_replace(' ', '_', strtolower($array['name']));

           //cache it for a year;
           $expiration = Carbon::now()->addYear();
           $this->cache->store($key, $array, $expiration);
           echo 'fetching coupon from service';
           return $array;
         }

     });

     $coupon = new Coupon($this->api, $coupon->first());
     echo get_class($coupon);

   }

   public function create($endpoint, $data)
   {
     $response = $this->crud('create', $endpoint, $data);
     return $this->handleResponse( new CustomersResponse(), $response );
   }

 }
