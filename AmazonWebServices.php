<?php

/**
 * @package    AmazonWebServicesBundle
 * @author     Mark Badolato <mbadolato@cybernox.com>
 * @copyright  Copyright (c) CyberNox Technologies. All rights reserved.
 * @license    http://www.opensource.org/licenses/BSD-2-Clause BSD License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AmazonWebServicesBundle;

/**
 * AmazonWebServicesBundle Main Service class
 */
class AmazonWebServices
{
    private $parameters = null;

    /**
     * Constructor
     *
     * @param array $parameters An array of configuration options
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

        \CFCredentials::set(array(
            'runtime'  => $parameters,
            '@default' => 'runtime'
        ));
    }

    /**
     * Get the accountId
     *
     * @return string The account id provided via the bundle configuration
     */
    public function accountId()
    {
        return $this->parameters['account_id'];
    }

    /**
     * Get the canonicalId
     *
     * @return string The cononical id provided via the bundle configuration
     */
    public function canonicalId()
    {
        return $this->parameters['canonical_id'];
    }

    /**
     * Get the cononicalName
     *
     * @return string The canonical name provided via the bundle configuration
     */
    public function canonicalName()
    {
        return $this->parameters['canonical_name'];
    }

    /**
     * Get the certificateAuthority
     *
     * @return string The certificate authority provided via the bundle configuration
     */
    public function certificateAuthority()
    {
        return (bool) $this->parameters['certificate_authority'];
    }

    /**
     * Get the cloudFrontKeypair
     *
     * @return string The Cloudfront keypair id provided via the bundle configuration
     */
    public function cloudfrontKeypair()
    {
        return $this->parameters['cloudfront_keypair'];
    }

    /**
     * Get the cloudfrontPem
     *
     * @return string The Cloudfront private key pem provided via the bundle configuration
     */
    public function cloudfrontPrivateKeyPem()
    {
        return $this->parameters['cloudfront_pem'];
    }

    /**
     * Get the defaultCacheConfig
     *
     * @return string The default cache config provided via the bundle configuration
     */
    public function defaultCacheConfig()
    {
        return $this->parameters['default_cache_config'];
    }

    /**
     * enableExtensions
     *
     * @return boolean
     */
    public function enableExtensions()
    {
        return (bool) $this->parameters['enable_extensions'];
    }

    /**
     * Get the key
     *
     * @return string The key provided via the bundle configuration
     */
    public function getKey()
    {
        return $this->parameters['key'];
    }

    /**
     * Get the parameters
     *
     * @return array The array of all configuration parameters provided via the bundle configuration
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get the mfaSerial
     *
     * @return string The mfa serial provided via the bundle configuration
     */
    public function mfaSerial()
    {
        return $this->parameters['mfa_serial'];
    }

    /**
     * Get the secret
     *
     * @return string The secret key provided via the bundle configuration
     */
    public function secret()
    {
        return $this->parameters['secret'];
    }
}
