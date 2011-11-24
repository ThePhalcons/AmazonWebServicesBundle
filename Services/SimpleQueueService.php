<?php

namespace Cybernox\AmazonWebServicesBundle\Services;

class SimpleQueueService
{
    private $sdk        = null;
    private $service    = null;

    public function __construct($sdk)
    {
        $this->sdk = $sdk;
    }

    public function loadServiceObject()
    {
        $this->service = new \AmazonSQS($this->sdk->getParam('key'), $this->sdk->getParam('secret_key'));
    }
}
