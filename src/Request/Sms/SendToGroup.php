<?php

namespace Zeit\SmsEagle\Request\Sms;

class SendToGroup extends BaseSms
{
    /**
     * @var string
     */
    protected $groupName;

    /**
     * @var string
     */
    protected $method = 'sms.send_togroup';

    /**
     * @param  string $groupName
     * @return $this
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge([
            'groupname' => $this->groupName,
        ], parent::getParams());
    }
}
