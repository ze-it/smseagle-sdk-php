<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class QueueLength extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'sms.get_queue_length';
}
