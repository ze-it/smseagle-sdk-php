<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class ListFolder extends BaseRequest
{
    /**
     * @var string
     */
    protected $folder = Folder::INBOX;

    /**
     * @var int|null
     */
    protected $fromId = null;

    /**
     * @var string|null
     */
    protected $to = null;

    /**
     * @var string|null
     */
    protected $from = null;

    /**
     * @var string|null
     */
    protected $toDate = null;

    /**
     * @var string|null
     */
    protected $fromDate = null;

    /**
     * @var int|null
     */
    protected $limit = null;

    /**
     * @var int|null
     */
    protected $unread = 0;

    /**
     * @var string
     */
    protected $method = 'sms.read_sms';

    /**
     * @param  string $folder
     * @return $this
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @param  int $fromId
     * @return $this
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;

        return $this;
    }

    /**
     * @param  int $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param  int $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param  DateTime|null $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        if (null !== $toDate) {
            $this->toDate = $toDate->format('YmdHis');
        }

        return $this;
    }

    /**
     * @param  DateTime|null $fromDate
     * @return $this
     */
    public function setFromDate($fromDate)
    {
        if (null !== $fromDate) {
            $this->fromDate = $fromDate->format('YmdHis');
        }

        return $this;
    }

    /**
     * @param  int|null $limit
     * @return $this
     */
    public function setLimit($limit = null)
    {
        $this->limit = (false == $limit) ? null : $limit;

        return $this;
    }

    /**
     * @param  bool $unread
     * @return $this
     */
    public function setUnreadOnly($unread = false)
    {
        $this->unread = $unread ? 1 : 0;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge([
            'folder' => $this->folder,
            'idfrom' => (string) $this->fromId,
            'from' => $this->from,
            'to' => $this->to,
            'datefrom' => $this->fromDate,
            'dateto' => $this->toDate,
            'limit' => (string) $this->limit,
            'unread' => (string) $this->unread,
        ], parent::getParams());
    }
}
