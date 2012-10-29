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

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Cybernox\AmazonWebServicesBundle\StreamWrapper\S3StreamWrapper;

/**
 * AmazonWebServicesBundle Main Bundle Class
 */
class CybernoxAmazonWebServicesBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (in_array('s3', $this->container->getParameter('cybernox_amazon_web_services.enable_extensions'))) {
            S3StreamWrapper::register($this->container->get('aws_s3'), 's3');
        }
    }
}
