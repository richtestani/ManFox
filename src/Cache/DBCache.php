<?php

namespace RichTestani\ManFox\Cache;
use Medoo\Medoo;

class DBCache {

    protected $last_result = null;

    protected $session;

    protected $cache;

    protected $prefix = 'fc_';

    protected $pluralize = true;

    public function __construct($session)
    {

        $this->session = $session;

        $this->cache = new Medoo([
          'database_type' => 'mysql',
          'database_name' => getenv('DATABASE_NAME'),
          'server' => getenv('DATABASE_HOST'),
          'username' => getenv('DATABASE_USER'),
          'password' => getenv('DATABASE_PASS'),
        ]);

    }

    public function has($node, $id) {

        $node = $this->getTableName($node);

        //cache result
        $this->last_result = $this->cache->select($node, '*', ['store_id' => $id]);

        //return result
        $result = $this->last_result;
        return (!empty($result)) ? true : false;

    }


    public function get($node, $id) {

        //return last cached result
        if(!is_null($this->last_result)) {

            $result = $this->last_result;
            $this->last_result = null;
            return $result;

        }

        //else fetch the data
        $node = $this->getTableName($node);

        $result = $this->cache->select($node, '*', ['store_id' => $id]);
        $this->last_result = $result;
        return $result;

    }

    public function put($node, $data) {

        $node = $this->getTableName($node);
        $this->cache->insert($node, $data);
        $id = $this->cache->id();
        $result = $this->cache->select($node, '*', ['store_id' => $id]);
        $this->last_result = $result;
        return $result;

    }

    private function getTableName($node)
    {
        $node = $this->prefix.$node;

        if($this->pluralize) {
            $node .= 's';
        }

        return $node;
    }

    public function getStore()
    {
		
		$store_id = $this->session->get('store_id');
		
		$store = null;
		
		if(is_null($store_id)) {
		
			$store_id = 1;
			
		}
		
		$this->session->put('store_id', $store_id);
		
		if( $this->has('store', $store_id) ) {
		
			$store = $this->get('store', $store_id);
			
		} else {
			
			$store = $this->cache->select('fc_stores', '*', 'ORDER BY id ASC LIMIT 1');
		
		}
		
		
		return $store;

    }

    public function getDefaultStore()
    {
        $store = $this->cache->select('fc_stores', '*', 'ORDER BY id ASC LIMIT 1');

        if(!empty($store)) {
            $this->session->put('store_id', $store[0]['id']);
        }

        return $store;

    }

}
