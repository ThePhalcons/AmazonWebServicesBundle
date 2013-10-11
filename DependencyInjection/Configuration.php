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

namespace Cybernox\AmazonWebServicesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
        $rootNode       = $treeBuilder->root('cybernox_amazon_web_services');

        $rootNode
            ->children()
                ->scalarNode('key')->isRequired()->end()
                ->scalarNode('secret')->isRequired()->end()
                ->scalarNode('account_id')->defaultValue(null)->end()
                ->scalarNode('canonical_id')->defaultValue(null)->end()
                ->scalarNode('canonical_name')->defaultValue(null)->end()
                ->scalarNode('mfa_serial')->defaultValue(null)->end()
                ->scalarNode('cloudfront_keypair')->defaultValue(null)->end()
                ->scalarNode('cloudfront_pem')->defaultValue(null)->end()
                ->scalarNode('default_cache_config')->defaultValue(null)->end()
                ->arrayNode('enable_extensions')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->scalarNode('sdk_path')->defaultValue('%kernel.root_dir%/../vendor/amazonwebservices/aws-sdk-for-php/sdk.class.php')->end()
                ->booleanNode('certificate_authority')->defaultFalse()->end()
                ->booleanNode('disable_auto_config')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
