<?php

namespace Zeit\SmsEagle\Response;

use DateTime;

class Sms
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->data['ID'];
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->data['TextDecoded'];
    }

    /**
     * @return string|null
     */
    public function getTo()
    {
        return isset($this->data['DestinationNumber']) ? $this->data['DestinationNumber'] : null;
    }

    /**
     * @return string|null
     */
    public function getFrom()
    {
        return isset($this->data['SenderNumber']) ? $this->data['SenderNumber'] : null;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->data['Status']) ? $this->data['Status'] : null;
    }

    /**
     * @return string|null
     */
    public function getStatusCode()
    {
        return isset($this->data['StatusCode']) ? $this->data['StatusCode'] : null;
    }

    /**
     * @return string|null
     */
    public function getStatusError()
    {
        return isset($this->data['StatusError']) ? $this->data['StatusError'] : null;
    }

    /**
     * @return string|null
     */
    public function getCreatorId()
    {
        return isset($this->data['CreatorID']) ? $this->data['CreatorID'] : null;
    }

    /**
     * @return string
     */
    public function getCoding()
    {
        return $this->data['Coding'];
    }

    /**
     * @return string|null
     */
    public function getUdh()
    {
        return !empty($this->data['UDH']) ? $this->data['UDH'] : null;
    }

    /**
     * @return string|null
     */
    public function getOid()
    {
        return !empty($this->data['oid']) ? $this->data['oid'] : null;
    }

    /**
     * @return bool|null
     */
    public function getRead()
    {
        return !empty($this->data['readed'])
            ? filter_var($this->data['readed'], FILTER_VALIDATE_BOOLEAN)
            : null;
    }

    /**
     * @return string
     */
    public function getSmsCenterNumber()
    {
        return $this->data['SMSCNumber'];
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        if (!isset($this->data['UpdatedInDb']) || null === $this->data['UpdatedInDb']) {
            return null;
        }

        return new DateTime($this->data['UpdatedInDb']);
    }

    /**
     * @return DateTime|null
     */
    public function getInsertedAt()
    {
        if (!isset($this->data['InsertIntoDB']) || null === $this->data['InsertIntoDB']) {
            return null;
        }

        return new DateTime($this->data['InsertIntoDB']);
    }

    /**
     * @return DateTime|null
     */
    public function getSentAt()
    {
        if (!isset($this->data['SendingDateTime']) || null === $this->data['SendingDateTime']) {
            return null;
        }

        return new DateTime($this->data['SendingDateTime']);
    }

    /**
     * @return DateTime|null
     */
    public function getReceivedAt()
    {
        if (!isset($this->data['ReceivingDateTime']) || null === $this->data['ReceivingDateTime']) {
            return null;
        }

        return new DateTime($this->data['ReceivingDateTime']);
    }
}
