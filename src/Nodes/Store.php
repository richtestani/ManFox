<?php

 namespace RichTestani\ManFox\Nodes;

 /**

 Node: Store
A single representation of a store

*/

 use RichTestani\ManFox\Contracts\iNode;
 use Illuminate\Support\Collection;
 use RichTestani\ManFox\Nodes;
 use RichTestani\ManFox\ManFoxCache;
 use RichTestani\ManFox\Models\Store as ManFoxStore;

 class Store extends Nodes implements iNode
 {

   protected $api;

   protected $url = '';

   protected $store_id;

   protected $store_links;

   public $collection;

   protected $coupons_link;

   protected $children = [
     'users',
     'customers',
     'store_version',
     'carts',
     'transactions',
     'subscriptions',
     'subscription_settings',
     'item_categories',
     'taxes'
   ];

   public function __construct($api, $manfox)
   {

     $this->api = $api;
     $this->session = Sessions::load('php');

     //$this->store_id = $this->session->get('store_id');


     // if( $this->cache->has('store') ) {
     //   $this->collection = $this->cache->get('store');
     // } else {
     //   $this->api->get($url);
     //   $this->collection = new Collection($this->api->response());
     //   $this->cache->store('store', $this->collection);
     // }
     //
     // $this->links();
     // $this->coupons_link = $this->getLink('fx:coupons', 'href');
   }

   public function coupons($coupon='')
   {

     $this->coupons = new Coupons($this->api, $this->coupons_link);

     if(!empty($coupon)) {

       //find specific coupon
       $coupon = $this->coupons->coupon($coupon);

       return $coupon;

     } else {
       return $this->coupons;
     }

   }

   public function getId()
   {
     return $this->store_id;
   }

   /* Private acces */
   private function setStoreId()
   {

     $urlparts = explode("/", parse_url($this->url, PHP_URL_PATH));

     $this->store_id = end($urlparts);

   }

   public function hasChild($child)
   {
     return (in_aray($this->children)) ? true : false;
   }

   public function getLink($child)
   {
     return $this->links($child);
   }

 }
