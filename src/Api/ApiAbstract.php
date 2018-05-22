<?php

namespace Zeit\SmsEagle\Api;

use Zeit\SmsEagle\Request\BaseRequest;
use Zeit\SmsEagle\Transport\TransportAbstract;

abstract class ApiAbstract
{
    /**
     * @var TransportAbstract
     */
    protected $transport;

    /**
     * @param  TransportAbstract $transport
     */
    public function __construct(TransportAbstract $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param  BaseRequest $request
     * @return mixed
     */
    public function request(BaseRequest $request)
    {
        return $this->transport->request($request);
    }
}
