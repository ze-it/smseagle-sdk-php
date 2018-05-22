<?php

namespace Zeit\SmsEagle\Request\Sms;

class SendToContact extends BaseSms
{
    /**
     * @var string
     */
    protected $contactName;

    /**
     * @var string
     */
    protected $method = 'sms.send_tocontact';

    /**
     * @param  string $contactName
     * @return $this
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge([
            'contactname' => $this->contactName,
        ], parent::getParams());
    }
}
