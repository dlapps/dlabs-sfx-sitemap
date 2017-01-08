<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Bundle service definition and processing of
 * semantic configuration.
 *
 * @package DL\SitemapBundle\DependencyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class DLSitemapExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->processConfiguration(new DLSitemapConfiguration, $configs);
        $this->processServiceDefinition($container);
    }

    /**
     * Process the service definition from a list of configuration files.
     *
     * @param ContainerBuilder $container
     */
    private function processServiceDefinition(ContainerBuilder $container): void
    {
        $definitionFiles = [
            'services.yml',
        ];

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        foreach ($definitionFiles as $file) {
            $loader->load($file);
        }
    }
}
