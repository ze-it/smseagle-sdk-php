<?php

namespace Zeit\SmsEagle\Api\Factory;

interface FactoryInterface
{
    /**
     * @param string $api
     *
     * @return bool
     */
    public function hasApi($api);

    /**
     * @param $api
     *
     * @return mixed
     */
    public function getApi($api);
}
