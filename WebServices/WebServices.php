<?php

namespace Cybernox\AmazonWebServicesBundle\WebServices;

abstract class WebServices
{
    private $service = null;

    public function __construct()
    {
        echo "I'm in the WebService";
        //$this->service = new WebService();
    }
}
