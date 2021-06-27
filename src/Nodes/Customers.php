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
 use RichTestani\ManFox\Responses\CustomersResponse;

 class Customers extends Nodes implements iNode
 {

   protected $api;

   protected $url = '';

   protected $store_id;

   protected $store_links;

   public $collection;

   protected $coupons_link;

   protected $base_url;

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
     $this->session = $manfox->getSession();
     $this->store_id = $this->session->get('store_id');
     $this->api->setHeader('Authorization', 'Bearer '.$_SESSION['manfox_access_token']);
     $this->base_url = '/customers/'.$this->store_id;

   }

   public function login($email, $password)
   {

     $store_id = $this->session->get('store_id');
     $storename = $this->session->get('storename');

     $form_params = [
       'ThisAction' => 'CheckLogin',
       'customer_email' => $email,
       'customer_password' => $password,
       'store_id' => $store_id
     ];

     $url = 'https://'.$storename.'.foxycart.com/v/2.0.0/api_json.php';
     $this->api->setHeader('Authorization', 'Bearer '.$_SESSION['manfox_access_token']);
     $this->api->addFormParam('ThisAction', 'CheckLogin');
     $this->api->addFormParam('customer_email', $email);
     $this->api->addFormParam('customer_password', $password);
     $this->api->addFormParam('store_id', $store_id);

     $this->api->post($url, $form_params, true);

     return $this->handleResponse(new CustomersResponse());

   }

   public function find($property, $value = '')
   {
     $params = '';
     if(is_array($property)) {
       $params = [];
       foreach($property as $name => $val) {
         $params[] = $name.'='.$val;
       }
       $params = implode('&', $params);
     } else {
       $params = $property.'='.$value;
     }
     $url = '/stores/'.$this->store_id.'/customers?'.$params;

     $this->api->get($url);

     return $this->handleResponse(new CustomersResponse());
   }

    public function update($endpoint, $data = [])
    {
     $response = $this->crud('update', $endpoint, $data);
     return $this->handleResponse( new CustomersResponse(), $response );
    }

    public function read($endpoint, $data = [])
    {
     $response = $this->crud('read', $endpoint, $data);
     return $this->handleResponse( new CustomersResponse(), $response );
    }

 }
