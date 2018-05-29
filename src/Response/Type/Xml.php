<?php

namespace Zeit\SmsEagle\Response\Type;

use Zeit\SmsEagle\Response\Sms;
use Zeit\SmsEagle\Exception\AuthErrorException;
use Zeit\SmsEagle\Exception\ResponseErrorException;

class Xml implements TypeInterface
{
    const TYPE = 'xml';

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
        $this->data = simplexml_load_string($data);

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
                return $this->convertSendSmsResponse();

            case 'sms.read_sms':
                return $this->convertSmsReadResponse();

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

        if (isset($this->data->error_text)) {
            $error = $this->data->error_text->__toString();

            if ('No data to display' === $error) {
                return;
            }

            if ('Invalid login or password' === $error) {
                throw new AuthErrorException($error);
            }

            throw new ResponseErrorException($error);
        }
    }

    /**
     * @return int[]
     */
    protected function convertSendSmsResponse()
    {
        if (isset($this->data->item)) {
            return array_column((array) $this->data->item, 'message_id');
        }

        return [$this->data->message_id];
    }

    /**
     * @return Sms[]
     */
    protected function convertSmsReadResponse()
    {
        if (isset($this->data->error_text)
            && 'No data to display' === $this->data->error_text->__toString()
        ) {
            return [];
        }

        $data = [];

        foreach ($this->data->messages->item as $item) {
            $sms = array_map([$this, 'emptyObjectToNull'], (array) $item);

            $data[] = new Sms($sms);
        }

        return $data;
    }

    /**
     * @return bool
     */
    protected function convertSmsDeleteResponse()
    {
        return ($this->data->status->__toString() === 'ok') ? true : false;
    }

    /**
     * @return int
     */
    protected function convertSmsQueueLengthResponse()
    {
        return (int) $this->data->queue_length;
    }

    /**
     * @return int
     */
    protected function convertSmsInboxQtyResponse()
    {
        return (int) $this->data->inbox_length;
    }

    /**
     * @return int
     */
    protected function convertSmsSentQtyResponse()
    {
        return (int) $this->data->sentitems_length;
    }

    /**
     * @param  mixed $field
     * @return mixed
     */
    protected function emptyObjectToNull($field)
    {
        return (is_object($field) && empty($field)) ? null : $field;
    }
}
