<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle semantic configuration.
 *
 * @package DL\SitemapBundle\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class DLSitemapConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('dl_sitemap');

        $rootNode
            ->children()
                ->scalarNode('location_prefix')
                    ->defaultValue('')
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
