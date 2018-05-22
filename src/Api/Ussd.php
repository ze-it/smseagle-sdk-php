<?php

namespace Zeit\SmsEagle\Api;

use Zeit\SmsEagle\Request\Ussd as UssdRequest;

class Ussd extends ApiAbstract
{
    /**
     * @param  string $ussd
     * @return int[]
     */
    public function send($ussd)
    {
        return $this->request(new UssdRequest(compact('ussd')));
    }
}
