<?php

namespace Zeit\SmsEagle\Api\Factory;

use Zeit\SmsEagle\Api;
use Zeit\SmsEagle\Exception\NoSuchNamespaceFoundException;

class MapFactory implements FactoryInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * Map of api namespaces to classes.
     *
     * @var array
     */
    protected $map = [];

    /**
     * Map of instances.
     *
     * @var array
     */
    protected $cache = [];

    /**
     * @param array $map
     * @param Api $api
     */
    public function __construct(array $map, $api)
    {
        $this->map = $map;
        $this->api = $api;
    }

    /**
     * @param  string $api
     * @return boolean
     */
    public function hasApi($api)
    {
        return isset($this->map[$api]);
    }

    /**
     * @param  string $api
     * @return mixed
     *
     * @throws NoSuchNamespaceFoundException
     */
    public function getApi($api)
    {
        if (!$this->hasApi($api)) {
            throw new NoSuchNamespaceFoundException('No api namespace found: ' . $api);
        }

        $class = $this->map[$api];

        if (isset($this->cache[$class])) {
            return $this->cache[$class];
        }

        $instance = new $class($this->api->getTransport());
        $this->cache[$class] = $instance;

        return $instance;
    }
}
