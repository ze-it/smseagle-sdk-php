<?php

namespace Zeit\SmsEagle\Transport;

use Zeit\SmsEagle\Helper\ConfigTrait;
use Zeit\SmsEagle\Request\BaseRequest;
use Zeit\SmsEagle\Response\Type\TypeInterface;

abstract class TransportAbstract
{
    use ConfigTrait;

    /**
     * @var TypeInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $defaultResponse = '';

    /**
     * @var array
     */
    protected $allowedResponses = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    /**
     * @param  BaseRequest $request
     * @return mixed
     */
    abstract public function request(BaseRequest $request);

    /**
     * @return TypeInterface
     */
    public function getResponse()
    {
        if (null === $this->response) {
            $this->setResponse(new $this->defaultResponse);
        }

        return $this->response;
    }

    /**
     * @param  TypeInterface $response
     */
    public function setResponse(TypeInterface $response)
    {
        if ($this->isResponseAllowed($response)) {
            throw new \Exception("Response not supported");
        }

        $this->response = $response;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return rtrim($this->getConfig('url'), '/') . '/';
    }

    /**
     * @param  TypeInterface $response
     * @return boolean
     */
    protected function isResponseAllowed(TypeInterface $response)
    {
        return !in_array($response->getType(), $this->allowedResponses);
    }

    /**
     * @param  string $result
     * @param  string $method
     * @return mixed
     */
    protected function prepareResponse($result, $method)
    {
        return $this->getResponse()->parse($result, $method);
    }

    /**
     * @param  BaseRequest $request
     * @return void
     */
    protected function prepareRequest(BaseRequest $request)
    {
        $request->setLogin($this->getConfig('login'))
            ->setPassword($this->getConfig('password'))
            ->setResponseType($this->getResponse()->getType());
    }
}
