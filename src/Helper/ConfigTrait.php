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
     * @return mixed
     */
    public function getConfig($field = null)
    {
        if (null === $field) {
            return $this->config;
        }

        return isset($this->config[$field]) ? $this->config[$field] : null;
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
