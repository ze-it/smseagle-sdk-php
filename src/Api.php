<?php

namespace Zeit\SmsEagle;

use Zeit\SmsEagle\Transport\Http;
use Zeit\SmsEagle\Transport\JsonRPC;
use Zeit\SmsEagle\Transport\TransportAbstract;
use Zeit\SmsEagle\Helper\ConfigTrait;
use Zeit\SmsEagle\Api\Factory\MapFactory;
use Zeit\SmsEagle\Api\Factory\FactoryInterface;
use Zeit\SmsEagle\Exception\WrongConfigurationException;
use Zeit\SmsEagle\Exception\NoSuchNamespaceFoundException;

class Api
{
    use ConfigTrait;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var TransportAbstract
     */
    protected $transport;

    /**
     * @param  array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
        $this->setFactory(new MapFactory([
            'sms' => 'Zeit\SmsEagle\Api\Sms',
            'ussd' => 'Zeit\SmsEagle\Api\Ussd',
        ], $this));

        $this->checkConfig($config);

        switch (strtolower($this->getConfig('type'))) {
            case 'json':
                $transport = new JsonRPC($this->getConfig('transport'));
                break;

            case 'http':
            //no break
            default:
                $transport = new Http($this->getConfig('transport'));
                break;
        }

        $this->setTransport($transport);
    }

    /**
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param  FactoryInterface $factory
     * @return $this
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return TransportAbstract
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param  TransportAbstract $transport
     * @return $this
     */
    public function setTransport(TransportAbstract $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param  string $name
     * @param  mixed $args
     * @return mixed
     *
     * @throws NoSuchNamespaceFoundException
     */
    public function __call($name, $args)
    {
        if (!$this->getFactory()->hasApi($name)) {
            throw new NoSuchNamespaceFoundException('No api namespace found: ' . $name);
        }

        $collection = $this->getFactory()->getApi($name);
        if (empty($args)) {
            return $collection;
        }

        return call_user_func_array($collection, $args);
    }

    /**
     * @param  string $name
     * @return mixed
     *
     * @throws NoSuchNamespaceFoundException
     */
    public function __get($name)
    {
        if (!$this->getFactory()->hasApi($name)) {
            throw new NoSuchNamespaceFoundException('No api namespace found: ' . $name);
        }

        return $this->getFactory()->getApi($name);
    }

    protected function checkConfig($config)
    {
        $transportConfig = $this->getConfig('transport');

        if (empty($this->getConfig('transport.url'))) {
            throw new WrongConfigurationException('Missing or empty transport url config entry!');
        }
    }
}
