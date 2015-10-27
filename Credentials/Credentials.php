<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 27/10/15
 * Time: 21:03
 */

namespace AmazonWebServicesBundle\Credentials;


/**
 * Class Credentials
 *
 * @package AmazonWebServicesBundle\Credentials
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 27/10/15 21:03
 * 
 */
class Credentials implements CredentialsInterface{

    private $parameters = array();

    function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the AWS access key ID for this credentials object.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->parameters['key'];
    }

    /**
     * Returns the AWS secret access key for this credentials object.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->parameters['secret'];
    }

}