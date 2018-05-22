<?php

namespace Zeit\SmsEagle\Request;

abstract class BaseRequest
{
    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $responseType;

    /**
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->fill($params);
    }

    /**
     * @param  array $params
     * @return void
     */
    public function fill(array $params)
    {
        foreach ($params as $param => $value) {
            if (null === $value) {
                continue;
            }

            $method = 'set' . ucfirst($param);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @param  string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param  string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param  string $responseType
     * @return $this
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return [
            'login' => $this->login,
            'pass'  => $this->password,
            'responsetype' => $this->responseType,
        ];
    }

    /**
     * @param  bool $short
     * @return string
     */
    public function getMethod($short = false)
    {
        if (!$short) {
            return $this->method;
        }

        list(, $method) = explode('.', $this->method);

        return $method;
    }
}
