<?php

namespace Zeit\SmsEagle\Response\Type;

use Zeit\SmsEagle\Response\Sms;

class Json implements TypeInterface
{
    const TYPE = 'extended';

    /**
     * @var array
     */
    protected $data;

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * @inheritdoc
     */
    public function parse($data, $method)
    {
        $this->data = json_decode($data, true)['result'];

        return $this->convert($method);
    }

    /**
     * @param  string $method
     * @return mixed
     */
    protected function convert($method)
    {
        switch ($method) {
            case 'sms.send_sms':
            case 'sms.send_togroup':
            case 'sms.send_tocontact':
            case 'sms.send_ussd':
            case 'sms.send_binary_sms':
                return $this->convertSmsSendResponse();

            case 'sms.read_sms':
                return $this->convertSmsListFolderResponse();

            case 'sms.delete_sms':
                return $this->convertSmsDeleteResponse();

            case 'sms.get_queue_length':
                return $this->convertSmsQueueLengthResponse();

            case 'sms.get_inbox_length':
                return $this->convertSmsInboxQtyResponse();

            case 'sms.get_sentitems_length':
                return $this->convertSmsSentQtyResponse();

            default:
                return null;
        }
    }

    /**
     * @return int[]
     */
    protected function convertSmsSendResponse()
    {
        if (isset($this->data['message_id'])) {
            return [$this->data['message_id']];
        }

        return array_column($this->data, 'message_id');
    }

    /**
     * @return Sms[]
     */
    protected function convertSmsListFolderResponse()
    {
        if (isset($this->data['error_text']) && $this->data['error_text'] === 'No data to display') {
            return [];
        }

        $data = [];

        foreach ($this->data['messages'] as $sms) {
            $data[] = new Sms($sms);
        }

        return $data;
    }

    /**
     * @return bool
     */
    protected function convertSmsDeleteResponse()
    {
        return ($this->data['status'] === 'ok') ? true : false;
    }

    /**
     * @return int
     */
    protected function convertSmsQueueLengthResponse()
    {
        return (int) $this->data['queue_length'];
    }

    /**
     * @return int
     */
    protected function convertSmsInboxQtyResponse()
    {
        return (int) $this->data['inbox_length'];
    }

    /**
     * @return int
     */
    protected function convertSmsSentQtyResponse()
    {
        return (int) $this->data['sentitems_length'];
    }
}
