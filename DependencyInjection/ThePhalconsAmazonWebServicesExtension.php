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

namespace AmazonWebServicesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * AmazonWebServicesBundle Extension setup and configuration
 */
class ThePhalconsAmazonWebServicesExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //not used any more services will be defined during configuration loading
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('aws_config.xml');
        $loader->load('aws_service.xml');

        foreach ($config as $key => $value) {
            $container->setParameter('the_phalcons_amazon_web_services.' . $key, $value);
        }


        foreach ($config['credentials'] as $key => $value) {
            $container->setParameter('the_phalcons_amazon_web_services.credentials.' . $key, $value);
        }
        foreach ($config['shared_config'] as $key => $value) {
            $container->setParameter('the_phalcons_amazon_web_services.shared_config.' . $key, $value);
        }


    }

    private function addFactoryDefinition(){
        //TODO: define config and factory services
    }

    /**
     * Inject service definition based on provided configuration
     * @param ContainerBuilder $container
     * @param $serviceType
     */
    private function addAwsSerivceDefinition(ContainerBuilder $container, $serviceType)
    {
        //TODO : implement aws services injection
    }

    public function getAlias()
    {
        return 'the_phalcons_amazon_web_services';
    }
}
