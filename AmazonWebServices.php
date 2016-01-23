<?php

namespace AmazonWebServicesBundle;

use Aws\Sdk;
use Aws\Credentials\Credentials;

/**
 * Class AmazonWebServices
 *
 * @package AmazonWebServicesBundle\SharedConfig
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 10/28/2015
 *
 */
class AmazonWebServices {

    /**
     * @var array
     */
    private $configs = array();

    /**
     * @var Sdk
     */
    private $sdk;

    /**
     * __constructor
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->configs = $config;

        // create a new aws credentials provider

        $credentials = new Credentials($this->getKey(), $this->getSecret());

        // it's more bette to use Credentials provide.
        // possibility to use memorize function which will cache your credentials
        // and optimize performances

        $this->sdk = new Sdk(
            array(
                'region'  => $this->getRegion(),
                // use specific aws sdk php version or latest version if not defined
                'version' => ($this->getVersion() != '' ) ? $this->getVersion() : 'latest',
                'credentials' => $credentials
            )
        );


    }

    /**
     * Create aws service clients
     * @param $serviceType
     * @return mixed
     */
    public function createAwsServiceClient($serviceType){

        return $this->sdk->createClient($serviceType);
    }

    /**
     * Get the accountId
     *
     * @return string The account id provided via the bundle configuration
     */
    public function accountId()
    {
        return $this->configs['account_id'];
    }
    /**
     * Get the canonicalId
     *
     * @return string The cononical id provided via the bundle configuration
     */
    public function canonicalId()
    {
        return $this->configs['canonical_id'];
    }
    /**
     * Get the cononicalName
     *
     * @return string The canonical name provided via the bundle configuration
     */
    public function canonicalName()
    {
        return $this->configs['canonical_name'];
    }
    /**
     * Get the certificateAuthority
     *
     * @return string The certificate authority provided via the bundle configuration
     */
    public function certificateAuthority()
    {
        return (bool) $this->configs['certificate_authority'];
    }
    /**
     * Get the cloudFrontKeypair
     *
     * @return string The Cloudfront keypair id provided via the bundle configuration
     */
    public function cloudfrontKeypair()
    {
        return $this->configs['cloudfront_keypair'];
    }
    /**
     * Get the cloudfrontPem
     *
     * @return string The Cloudfront private key pem provided via the bundle configuration
     */
    public function cloudfrontPrivateKeyPem()
    {
        return $this->configs['cloudfront_pem'];
    }
    /**
     * Get the defaultCacheConfig
     *
     * @return string The default cache config provided via the bundle configuration
     */
    public function defaultCacheConfig()
    {
        return $this->configs['default_cache_config'];
    }
    /**
     * enableExtensions
     *
     * @return boolean
     */
    public function enableExtensions()
    {
        return (bool) $this->configs['enable_extensions'];
    }
    /**
     * Get the key
     *
     * @return string The key provided via the bundle configuration
     */
    public function getKey()
    {
        return $this->configs['key'];
    }
    /**
     * Get the parameters
     *
     * @return array The array of all configuration parameters provided via the bundle configuration
     */
    public function getConfigs()
    {
        return $this->configs;
    }
    /**
     * Get the mfaSerial
     *
     * @return string The mfa serial provided via the bundle configuration
     */
    public function mfaSerial()
    {
        return $this->configs['mfa_serial'];
    }
    /**
     * Get the secret
     *
     * @return string The secret key provided via the bundle configuration
     */
    public function getSecret()
    {
        return $this->configs['secret'];
    }

    /**
     * Get the mfaSerial
     *
     * @return string The mfa serial provided via the bundle configuration
     */
    public function getVersion()
    {
        return $this->configs['version'];
    }
    /**
     * Get the secret
     *
     * @return string The secret key provided via the bundle configuration
     */
    public function getRegion()
    {
        return $this->configs['region'];
    }
}

