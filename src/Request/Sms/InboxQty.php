<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class InboxQty extends BaseRequest
{
    /**
     * @var string
     */
    protected $method = 'sms.get_inbox_length';
}
