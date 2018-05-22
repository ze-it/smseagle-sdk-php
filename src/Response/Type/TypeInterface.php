<?php

namespace Zeit\SmsEagle\Response\Type;

interface TypeInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param  string $data
     * @param  string $method
     *
     * @return $this
     */
    public function parse($data, $method);
}
