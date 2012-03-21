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

namespace Cybernox\AmazonWebServicesBundle;

/**
 * AmazonWebServicesBundle Factory providing requested AWS objects
 */
class AmazonWebServicesFactory
{
    /**
     * @var array $validServiceTypes The names of the Amazon Web Services that may be used
     */
    private $validServiceTypes = array(
        'AS',
        'CloudFormation',
        'CloudFront',
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
     * Get an Amazon Web Service object
     *
     * @param  AmazonWebServices $aws         An AmazonWebServices Service instance
     * @param  string            $serviceType The requested Amazon Web Service type
     * @return mixed The requested Amazon Web Service Object
     * @throws \RuntimeException
     */
    public function get(AmazonWebServices $aws, $serviceType)
    {
        if (! $this->isValidServiceType($serviceType))
        {
            throw new \RuntimeException(sprintf('Invalid Amazon Web Service Type requested [%s]', $serviceType));
        }

        $serviceObject = 'Amazon' . $serviceType;
        return new $serviceObject($aws->getParameters());
    }

    /**
     * Determine if a requested Amazon Web Service is valid or not
     * 
     * @param $type string The requested Amazon Web Service type
     * @return bool
     */
    private function isValidServiceType($type)
    {
        return (in_array($type, $this->validServiceTypes) ? true : false);
    }
}
