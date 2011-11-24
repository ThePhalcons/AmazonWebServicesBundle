<?php

namespace Cybernox\AmazonWebServicesBundle\Services;

class Service
{
    private $parameters = null;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParam($parameter)
    {
        if (array_key_exists($parameter, $this->parameters))
        {
            return $this->parameters[$parameter];
        }
    }
}
