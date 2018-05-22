<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class SendBinary extends BaseRequest
{
    /**
     * @var string|string[]
     */
    protected $to;

    /**
     * @var string|null
     */
    protected $udh = null;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var string|null
     */
    protected $class = null;

    /**
     * @var int|null
     */
    protected $modemNo = null;

    /**
     * @var string
     */
    protected $method = 'sms.send_binary_sms';

    /**
     * @param  string|string[] $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = implode(',', array_wrap($to));

        return $this;
    }

    /**
     * @param  string $udh
     * @return $this
     */
    public function setUdh($udh)
    {
        $this->udh = $udh;

        return $this;
    }

    /**
     * @param  string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

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
        return array_merge([
            'to' => $this->to,
            'udh' => $this->udh,
            'data' => $this->data,
            'class' => $this->class,
            'modem_no' => (string) $this->modemNo,
        ], parent::getParams());
    }
}
