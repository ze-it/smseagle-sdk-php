<?php

namespace Zeit\SmsEagle\Request\Sms;

class Send extends BaseSms
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string|null
     */
    protected $oid = null;

    /**
     * @var string
     */
    protected $method = 'sms.send_sms';

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
     * @param  string $oid
     * @return $this
     */
    public function setOid($oid)
    {
        $this->oid = $oid;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge([
            'to' => $this->to,
            'oid' => $this->oid,
        ], parent::getParams());
    }
}
