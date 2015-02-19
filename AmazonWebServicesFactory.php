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
     * Constructor
     *
     * @param array $config     The user defined config
     */
    public function __construct(array $config)
    {
        if ($config['disable_auto_config'] && (! defined('AWS_DISABLE_CONFIG_AUTO_DISCOVERY'))) {
            define('AWS_DISABLE_CONFIG_AUTO_DISCOVERY', TRUE);
        }

        if (isset($config['sdk_path']) && file_exists($config['sdk_path'])) {
            require_once $config['sdk_path'];
        }
    }

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
        if (! $this->isValidServiceType($serviceType)) {
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
