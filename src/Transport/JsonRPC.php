<?php

namespace Zeit\SmsEagle\Transport;

use Zeit\SmsEagle\Response\Type\Json;

class JsonRPC extends TransportAbstract
{
    /**
     * @inheritdoc
     */
    protected $defaultResponse = Json::class;

    /**
     * @inheritdoc
     */
    protected $allowedResponses = [
        Json::TYPE,
    ];

    /**
     * @inheritdoc
     */
    public function request($request)
    {
        $this->prepareRequest($request);

        $handle = curl_init();
        $curlOptions = isset($this->config['options']['curl']) ? $this->config['options']['curl'] : [];

        $fields = json_encode([
            'method' => $request->getMethod(),
            'params' => $request->getParams(),
        ]);

        curl_setopt_array($handle, $curlOptions);
        curl_setopt_array($handle, [
            CURLOPT_URL => $this->buildUrl(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_NOBODY => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $result = curl_exec($handle);

        curl_close($handle);

        return $this->prepareResponse($result, $request->getMethod());
    }

    /**
     * @return string
     */
    protected function buildUrl()
    {
        return $this->getUrl() . 'jsonrpc/sms';
    }
}
