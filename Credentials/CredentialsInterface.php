<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 27/10/15
 * Time: 20:59
 */

namespace AmazonWebServicesBundle\Credentials;

/**
 * Interface CredentialsInterface
 *
 * @package AmazonWebServicesBundle\Credentials
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 27/10/15 20:59
 * 
 */
interface CredentialsInterface {

    /**
     * Returns the AWS access key ID for this credentials object.
     *
     * @return string
     */
    public function getKey();

    /**
     * Returns the AWS secret access key for this credentials object.
     *
     * @return string
     */
    public function getSecret();

}