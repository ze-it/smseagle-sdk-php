<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class SentQty extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'sms.get_sentitems_length';
}
