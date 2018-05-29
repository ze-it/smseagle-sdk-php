<?php

namespace Zeit\SmsEagle\Helper;

trait ConfigTrait
{
   /**
     * @var array
     */
    protected $config;

    /**
     * @param  string|null $field
     * @param  mixed $default
     * @return mixed
     */
    public function getConfig($field = null, $default = null)
    {
        if (null === $field) {
            return $this->config;
        }

        return array_get($this->config, $field, $default);
    }

    /**
     * @param  array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}
