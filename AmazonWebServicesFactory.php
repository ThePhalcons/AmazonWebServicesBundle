<?php
/**
 * Created by PhpStorm.
 * User: elmehdi
 * Date: 27/10/15
 * Time: 20:52
 */

namespace AmazonWebServicesBundle;
use AmazonWebServicesBundle\AmazonWebServices;


/**
 * Class AmazonWebServicesFactory
 *
 * @package AmazonWebServicesBundle\ServiceFactory
 *
 * @Author : El Mehdi Mouddene  <mouddene@gmail.com>
 *
 * Initial version created on: 27/10/15 20:52
 * 
 */
class AmazonWebServicesFactory {

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
        'Route53',
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
    public function get(AmazonWebServices $aws, $serviceType)
    {
        //delegate service creation to aws sdk
        return $aws->createAwsServiceClient($serviceType);
    }
}