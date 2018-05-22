<?php

namespace Zeit\SmsEagle\Request;

class Ussd extends BaseRequest
{
    /**
     * @var string
     */
    protected $ussd;

    /**
     * @var int|null
     */
    protected $modemNo = null;

    /**
     * @var string
     */
    protected $method = 'sms.send_ussd';

    /**
     * @param  string $ussd
     * @return $this
     */
    public function setUssd($ussd)
    {
        $this->ussd = $ussd;

        return $this;
    }

    /**
     * @param  int $modemNo
     * @return $this
     */
    public function setModemNo($modemNo)
    {
        $this->modemNo = $modemNo;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge(parent::getParams(), [
            'to' => $this->ussd,
        ]);
    }
}
