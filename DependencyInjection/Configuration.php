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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * AmazonWebServicesBundle Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder    = new TreeBuilder();
        $rootNode       = $treeBuilder->root('amazon_web_services');


        $this->addWSConfiguration($rootNode);
        $this->addServicesConfiguration($rootNode);

        return $treeBuilder;
    }

    private function addWSConfiguration(ArrayNodeDefinition $node){
        $node
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('key')->isRequired()->end()
                        ->scalarNode('secret')->isRequired()->end()
                    ->end() //children
                ->end() //credentials
                ->arrayNode('shared_config')
                    ->children()
                        ->scalarNode('account_id')->defaultValue(null)->end()
                        ->scalarNode('canonical_id')->defaultValue(null)->end()
                        ->scalarNode('canonical_name')->defaultValue(null)->end()
                        ->scalarNode('mfa_serial')->defaultValue(null)->end()
                        ->scalarNode('cloudfront_keypair')->defaultValue(null)->end()
                        ->scalarNode('cloudfront_pem')->defaultValue(null)->end()
                        ->scalarNode('default_cache_config')->defaultValue(null)->end()
                        ->arrayNode('enable_extensions')->defaultValue(array())->prototype('scalar')->end()->end()
                        ->booleanNode('certificate_authority')->defaultFalse()->end()
                        ->booleanNode('disable_auto_config')->defaultFalse()->end()
                    ->end() //children
                ->end() //shared_config
            ->end(); //children
    }

    private function addServicesConfiguration(ArrayNodeDefinition $node){

        //TODO: adapte config to given aws.config.yml
        $node
            ->children()
                ->arrayNode('services')
                    ->children()
                        ->arrayNode('S3')
                            ->children()
                                ->booleanNode('isInjectable')->isRequired()->defaultFalse()->end()
                                    ->scalarNode('uploadBucket')->isRequired()->end()
                                        ->arrayNode('upload')
                                        ->children()
                                        ->scalarNode('rentalBasePath')->isRequired()->end()
                                        ->scalarNode('profilePictureBaseUrl')->isRequired()->end()
                                        ->scalarNode('drivingLicenceBaseUrl')->isRequired()->end()
                                        ->end()
                                        ->end() //upload
                                        ->end()
                                        ->end() //amazon s3
                                        ->arrayNode('CloudFront')
                                        ->children()
                                        ->booleanNode('isInjectable')->isRequired()->defaultFalse()->end()
                                        ->scalarNode('cf_uploads')->isRequired()->end()
                                ->scalarNode('cf_assets')->isRequired()->end()
                            ->end() //children
                        ->end() //Cloud front
                    ->end() //children
                ->end() //services
            ->end(); //children
}
