<?php

namespace RichTestani\ManFox;

/**

* A wrapper for Laravels own file cache

* This class allows the same conventions as using Laravel
* This class helps remove a specific class implmentation,
* while still tightly coupled to Laravel.

* Future versions might want to build a cache adapter
* or default with it's own simple cache tool

*/

use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;

class ManFoxCache {

  protected $cache_path = __DIR__.'/Cache/';

  protected $file;

  protected $expires;

  protected $cache;

  public function __construct($config)
  {
    foreach($config as $k => $v) {
      $this->$k = $v;
    }

    //configure this cache
    if(!is_dir($this->cache_path)) {
      mkdir($this->cache_path, 0700);
    }

    /*

    From: https://github.com/mattstauffer/Torch/blob/5.1/components/cache/index.php#L8

    */

    // Create a new Container object, needed by the cache manager.
    $container = new Container;
    // The CacheManager creates the cache "repository" based on config values
    // which are loaded from the config class in the container.
    // More about the config class can be found in the config component; for now we will use an array
    $container['config'] = [
        'cache.default' => 'file',
        'cache.stores.file' => [
            'driver' => 'file',
            'path' => $this->cache_path
        ]
    ];
    // To use the file cache driver we need an instance of Illuminate's Filesystem, also stored in the container
    $container['files'] = new Filesystem;
    // Create the CacheManager
    $cacheManager = new CacheManager($container);

    $this->cache = $cacheManager->store();

  }

  public function store($key, $value, $expires = 120)
  {
    $this->cache->put($key, $value, $expires);
  }

  public function put($key, $value, $expires = 120)
  {
    $this->store($key, $value, $expires);
  }

  public function get($key)
  {
    return $this->cache->get($key);
  }

  public function has($key)
  {
    return $this->cache->has($key);
  }

}
 ?>
