<?php

namespace Zeit\SmsEagle\Request\Sms;

use Zeit\SmsEagle\Request\BaseRequest;

class Delete extends BaseRequest
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
     * @var int|null
     */
    protected $toId = null;

        /**
     * @var string
     */
    protected $method = 'sms.delete_sms';

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
     * @param  int $toId
     * @return $this
     */
    public function setToId($toId)
    {
        $this->toId = $toId;

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
            'idto' => (string) $this->toId,
        ], parent::getParams());
    }
}
