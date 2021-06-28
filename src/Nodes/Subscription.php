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

 class Subscription extends Nodes implements iNode
 {

   protected $api;

   protected $url = '';

   protected $store_id;


   public function __construct($api, $manfox)
   {

     $this->api = $api;
     $this->session = $manfox->getSession();

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
