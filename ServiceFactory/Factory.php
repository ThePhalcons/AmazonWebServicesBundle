<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 27/10/15
 * Time: 20:52
 */

namespace AmazonWebServicesBundle\ServiceFactory;
use AmazonWebServicesBundle\SharedConfig\SharedConfig;


/**
 * Class Factory
 *
 * @package AmazonWebServicesBundle\ServiceFactory
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 27/10/15 20:52
 * 
 */
class Factory {

    /**
     * @var array $validServiceTypes The names of the Amazon Web Services that may be used
     */
    private $supportedServiceTypes = array(
        'AS',
        'CloudFormation',
        'CloudFront',
        'CloudSearch',
        'CloudWatch',
        'DynamoDB',
        'EC2',
        'ELB',
        'EMR',
        'ElastiCache',
        'ElasticBeanstalk',
        'IAM',
        'ImportExport',
        'RDS',
        'S3',
        'SDB',
        'SES',
        'SNS',
        'SQS',
        'STS',
        'SWF',
    );

    /**
     * checks if the given service type is supported
     * @param $serviceType
     * @return bool
     */
    private function isSupportedServiceType($serviceType){
        return in_array($serviceType, $this->supportedServiceTypes);
    }

    /**
     * Factory service creation method
     * @param SharedConfig $configs
     * @param $serviceType
     * @return mixed
     */
    public function get(SharedConfig $configs, $serviceType)
    {
        //delegate service client create to aws sdk
        return $configs->createClient($serviceType);
    }
}