<?php

namespace Cybernox\AmazonWebServicesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
                ->scalarNode('account_id')->end()
                ->scalarNode('canonical_id')->end()
                ->scalarNode('canonical_name')->end()
                ->scalarNode('mfa_serial')->end()
                ->scalarNode('cloudfront_keypair_id')->end()
                ->scalarNode('cloudfront_private_key_pem')->end()
                ->scalarNode('default_cache_config')->end()
                ->booleanNode('enable_extensions')->defaultFalse()->end()
                ->booleanNode('certificate_authority')->defaultFalse()->end()
                ->scalarNode('assoc_id')->end()
            ->end();

        return $treeBuilder;
    }
}
