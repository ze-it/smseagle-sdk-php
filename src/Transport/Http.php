<?php

namespace Zeit\SmsEagle\Transport;

use Zeit\SmsEagle\Response\Type\Xml;

class Http extends TransportAbstract
{
    /**
     * @inheritdoc
     */
    protected $defaultResponse = Xml::class;

    /**
     * @inheritdoc
     */
    protected $allowedResponses = [
        Xml::TYPE,
    ];

    /**
     * @inheritdoc
     */
    public function request($request)
    {
        $this->prepareRequest($request);

        $handle = curl_init();
        $curlOptions = $this->getConfig('options.curl', []);

        curl_setopt_array($handle, $curlOptions);
        curl_setopt_array($handle, [
            CURLOPT_URL => $this->buildUrl($request->getMethod(true), $request->getParams()),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $result = curl_exec($handle);

        curl_close($handle);

        return $this->prepareResponse($result, $request->getMethod());
    }

    /**
     * @param  string $method
     * @param  array $params
     * @return string
     */
    protected function buildUrl($method, $params)
    {
        return $this->getUrl() . 'http_api/' . $method . '?' . http_build_query($params);
    }
}
