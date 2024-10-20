<?php

namespace App\Libraries;

use Config\Cache;
use CodeIgniter\Cache\Handlers\MemcachedHandler;

class MemcachedAdapter extends MemcachedHandler
{
    public function __construct(Cache $config)
    {
        parent::__construct($config);

        // Configurar para GAE
        if (getenv('GAE_INSTANCE')) {
            // Estamos en GAE
            $this->config['host'] = getenv('GAE_MEMCACHE_HOST') ?: 'localhost';
            $this->config['port'] = 11211;
        }

        $this->memcached = new \Memcached();
        $this->memcached->addServer($this->config['host'], $this->config['port'], $this->config['weight']);
    }
}