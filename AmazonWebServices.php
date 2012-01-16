<?php

namespace Cybernox\AmazonWebServicesBundle;

class AmazonWebServices
{
    private $parameters = null;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

        \CFCredentials::set(array(
            'runtime'  => $parameters,
            '@default' => 'runtime'
        ));
    }

    public function accountId()
    {
        return $this->parameters['account_id'];
    }

    public function canonicalId()
    {
        return $this->parameters['canonical_id'];
    }

    public function canonicalName()
    {
        return $this->parameters['canonical_name'];
    }

    public function certificateAuthority()
    {
        return (bool) $this->parameters['certificate_authority'];
    }

    public function cloudfrontKeypairId()
    {
        return $this->parameters['cloudfront_keypair_id'];
    }

    public function cloudfrontPrivateKeyPem()
    {
        return $this->parameters['cloudfront_private_key_pem'];
    }

    public function defaultCacheConfig()
    {
        return $this->parameters['default_cache_config'];
    }

    public function enableExtensions()
    {
        return (bool) $this->parameters['enable_extensions'];
    }

    public function getKey()
    {
        return $this->parameters['key'];
    }

    public function mfaSerial()
    {
        return $this->parameters['mfa_serial'];
    }

    public function getSecret()
    {
        return $this->parameters['secret'];
    }

    public function getParameters()
    {
        return $this->parameters;
    }
    
}
