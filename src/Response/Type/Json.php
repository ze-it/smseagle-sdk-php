<?php

namespace Zeit\SmsEagle\Response\Type;

use Zeit\SmsEagle\Response\Sms;
use Zeit\SmsEagle\Exception\AuthErrorException;
use Zeit\SmsEagle\Exception\ResponseErrorException;

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
        $this->data = json_decode($data, true);

        if (isset($this->data['result'])) {
            // Documentation says that it also wraps error fields in result JSON object
            // {"result": {"error_text":"Invalid login or password","status":"error"}}
            //  but in fact it does not...
            $this->data = $this->data['result'];
        }

        return $this->convert($method);
    }

    /**
     * @param  string $method
     * @return mixed
     */
    protected function convert($method)
    {
        $this->checkForErrors();

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
     * @return void
     *
     * @throws AuthErrorException
     * @throws ResponseErrorException
     */
    protected function checkForErrors()
    {
        if (isset($this->data['error_text'])) {
            if ('No data to display' === $this->data['error_text']) {
                return;
            }

            if ('Invalid login or password' === $this->data['error_text']) {
                throw new AuthErrorException($this->data['error_text']);
            }

            throw new ResponseErrorException($this->data['error_text']);
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
        if (isset($this->data['error_text'])
            && 'No data to display' === $this->data['error_text']
        ) {
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
        return ('ok' === $this->data['status']) ? true : false;
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
