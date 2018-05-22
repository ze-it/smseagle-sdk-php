<?php

namespace Zeit\SmsEagle\Api;

use DateTime;
use Zeit\SmsEagle\Request\Sms\Folder;
use Zeit\SmsEagle\Request\Sms\Send as SendRequest;
use Zeit\SmsEagle\Request\Sms\SendToGroup as SendToGroupRequest;
use Zeit\SmsEagle\Request\Sms\SendToContact as SendToContactRequest;
use Zeit\SmsEagle\Request\Sms\SendBinary as SendBinaryRequest;
use Zeit\SmsEagle\Request\Sms\ListFolder as ListFolderRequest;
use Zeit\SmsEagle\Request\Sms\Delete as DeleteRequest;
use Zeit\SmsEagle\Request\Sms\QueueLength as QueueLengthRequest;
use Zeit\SmsEagle\Request\Sms\InboxQty as InboxQtyRequest;
use Zeit\SmsEagle\Request\Sms\SentQty as SentQtyRequest;

class Sms extends ApiAbstract
{
    /**
     * @param  string $message
     * @param  string|string[] $to
     * @param  array $params
     * @return int[]
     */
    public function send($message, $to, $params = [])
    {
        $params = array_merge($params, compact('to', 'message'));

        return $this->request(new SendRequest($params));
    }

    /**
     * @param  string $message
     * @param  string $groupName
     * @param  array $params
     * @return int[]
     */
    public function sendToGroup($message, $groupName, $params = [])
    {
        $params = array_merge($params, compact('message', 'groupName'));

        return $this->request(new SendToGroupRequest($params));
    }

    /**
     * @param  string $message
     * @param  string $contactName
     * @param  array $params
     * @return int[]
     */
    public function sendToContact($message, $contactName, $params = [])
    {
        $params = array_merge($params, compact('message', 'contactName'));

        return $this->request(new SendToContactRequest($params));
    }

    /**
     * @param  string $data
     * @param  string|string[] $to
     * @param  array $params
     * @return int[]
     */
    public function sendBinary($data, $to, $params = [])
    {
        $params = array_merge($params, compact('data', 'to'));

        return $this->request(new SendBinaryRequest($params));
    }

    /**
     * @param  array  $params
     * @return Zeit\SmsEagle\Response\Sms[]
     */
    public function search($params = [])
    {
        return $this->request(new ListFolderRequest($params));
    }

    /**
     * @param  DateTime|null $fromDate
     * @param  DateTime|null $toDate
     * @param  string|null $from
     * @param  bool|null $unread
     * @param  int|null $limit
     * @return Zeit\SmsEagle\Response\Sms[]
     */
    public function searchInbox(
        DateTime $fromDate = null,
        DateTime $toDate = null,
        $from = null,
        $unread = null,
        $limit = null
    ) {
        $folder = Folder::INBOX;

        return $this->search(compact('folder', 'from', 'fromDate', 'toDate', 'unread', 'limit'));
    }

    /**
     * @param  DateTime|null $fromDate
     * @param  DateTime|null $toDate
     * @param  string|null $to
     * @param  int|null $limit
     * @return Zeit\SmsEagle\Response\Sms[]
     */
    public function searchSent(
        DateTime $fromDate = null,
        DateTime $toDate = null,
        $to = null,
        $limit = null
    ) {
        $folder = Folder::SENT;

        return $this->search(compact('folder', 'to', 'fromDate', 'toDate', 'limit'));
    }

    /**
     * @param  DateTime|null $fromDate
     * @param  DateTime|null $toDate
     * @param  string|null $to
     * @param  int|null $limit
     * @return Zeit\SmsEagle\Response\Sms[]
     */
    public function searchOutbox(
        DateTime $fromDate = null,
        DateTime $toDate = null,
        $to = null,
        $limit = null
    ) {
        $folder = Folder::OUTBOX;

        return $this->search(compact('folder', 'to', 'fromDate', 'toDate', 'limit'));
    }

    /**
     * @param  array $params
     * @return bool
     */
    public function delete($params = [])
    {
        return $this->request(new DeleteRequest($params));
    }

    /**
     * @param  int $from
     * @param  int|null $to
     * @return bool
     */
    public function deleteInbox($fromId, $toId = null)
    {
        $folder = Folder::INBOX;

        if (null === $toId) {
            $toId = $fromId;
        }

        return $this->delete(compact('folder', 'fromId', 'toId'));
    }

    /**
     * @param  int $from
     * @param  int|null $to
     * @return bool
     */
    public function deleteSent($fromId, $toId = null)
    {
        $folder = Folder::SENT;

        if (null === $toId) {
            $toId = $fromId;
        }

        return $this->delete(compact('folder', 'fromId', 'toId'));
    }

    /**
     * @param  int $from
     * @param  int|null $to
     * @return bool
     */
    public function deleteOutbox($fromId, $toId = null)
    {
        $folder = Folder::OUTBOX;

        if (null === $toId) {
            $toId = $fromId;
        }

        return $this->delete(compact('folder', 'fromId', 'toId'));
    }

    /**
     * @return int
     */
    public function queueLength()
    {
        return $this->request(new QueueLengthRequest());
    }

    /**
     * @return int
     */
    public function inboxQty()
    {
        return $this->request(new InboxQtyRequest());
    }

    /**
     * @return int
     */
    public function sentQty()
    {
        return $this->request(new SentQtyRequest());
    }
}
