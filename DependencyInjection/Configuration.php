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
                ->scalarNode('account_id')->defaultValue(null)->end()
                ->scalarNode('canonical_id')->defaultValue(null)->end()
                ->scalarNode('canonical_name')->defaultValue(null)->end()
                ->scalarNode('mfa_serial')->defaultValue(null)->end()
                ->scalarNode('cloudfront_keypair_id')->defaultValue(null)->end()
                ->scalarNode('cloudfront_private_key_pem')->defaultValue(null)->end()
                ->scalarNode('default_cache_config')->defaultValue(null)->end()
                ->booleanNode('enable_extensions')->defaultFalse()->end()
                ->booleanNode('certificate_authority')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
