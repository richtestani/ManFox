<?php

namespace RichTestani\ManFox\Nodes;

/**

Node: PropertyHelpers

*/

use RichTestani\ManFox\Contracts\iNode;
use Illuminate\Support\Collection;
use RichTestani\ManFox\Nodes;
use RichTestani\ManFox\ManFoxCache;
use RichTestani\ManFox\Models\Store as ManFoxStore;

class PropertyHelpers extends Nodes implements iNode
{

  public function __construct($api, $manfox)
  {

    $this->api = $api;
    $this->session = $manfox->getSession();

    $this->store_id = $this->session->get('store_id');
    $url = '/property_helpers';
    $this->api->get($url);
    $this->helpers = $this->api->response();

  }

  public function countries()
  {
    $endpoint = $this->helpers['_links']['fx:regions']['href'];

    $this->api->setHeader('Authorization', 'Bearer '.$_SESSION['manfox_access_token']);
    $this->api->get('/property_helpers/countries');
    return $this->api->response();
  }

  public function regions($code = 'US')
  {
    $endpoint = $this->helpers['_links']['fx:regions']['href'];

    $this->api->setHeader('Authorization', 'Bearer '.$_SESSION['manfox_access_token']);
    $this->api->get('/property_helpers/regions?country_code='.$code);
    return $this->api->response();
  }
}


 ?>
