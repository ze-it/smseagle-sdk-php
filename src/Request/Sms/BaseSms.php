<?php

namespace Zeit\SmsEagle\Request\Sms;

use DateTime;
use Zeit\SmsEagle\Request\BaseRequest;

abstract class BaseSms extends BaseRequest
{
    /**
     * @var string|null
     */
    protected $date = null;

    /**
     * @var int
     */
    protected $flash = 0;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var int
     */
    protected $unicode = 0;

    /**
     * @var int|null
     */
    protected $modemNo = null;

    /**
     * @var int
     */
    protected $highPriority = 0;

    /**
     * @param  DateTime|null $date
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        if (null !== $date) {
            $this->date = $date->format('YmdHi');
        }

        return $this;
    }

    /**
     * @param  mixed $flash
     * @return $this
     */
    public function setFlash($flash)
    {
        $this->flash = ($flash == true) ? 1 : 0;

        return $this;
    }

    /**
     * @param  string $message
     * @return $this
     */
    public function setMessage($message = '')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param  mixed $unicode
     * @return $this
     */
    public function setUnicode($unicode)
    {
        $this->unicode = ($unicode == true) ? 1 : 0;

        return $this;
    }

    /**
     * @param  int|null $modemNo
     * @return $this
     */
    public function setModemNo($modemNo)
    {
        $this->modemNo = $modemNo;

        return $this;
    }

    /**
     * @param  mixed $highPriority
     * @return $this
     */
    public function setHighPriority($highPriority)
    {
        $this->highPriority = ($highPriority == true) ? 1 : 0;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge([
            'message'  => $this->message,
            'date' => $this->date,
            'highpriority' => (string) $this->highPriority,
            'unicode' => (string) $this->unicode,
            'flash' => (string) $this->flash,
            'modem_no' => (string) $this->modemNo,
        ], parent::getParams());
    }
}
