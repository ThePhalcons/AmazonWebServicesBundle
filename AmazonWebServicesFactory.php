<?php

namespace Cybernox\AmazonWebServicesBundle;

class AmazonWebServicesFactory
{
    private $validServiceTypes = array(
        'AS',
        'CloudFormation',
        'CloudFront',
        'CloudWatch',
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
        'PAS',
    );

    public function get(AmazonWebServices $aws, $serviceType)
    {
        if (! $this->isValidServiceType($serviceType))
        {
            throw new \RuntimeException(sprintf('Invalid Amazon Web Service Type requested [%s]', $serviceType));
        }

        $serviceObject = 'Amazon' . $serviceType;
        return new $serviceObject($aws->getParameters());
    }

    private function isValidServiceType($type)
    {
        return (in_array($type, $this->validServiceTypes) ? true : false);
    }
}
