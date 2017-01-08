<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\DependecyInjection;

use DL\SitemapBundle\DependencyInjection\DLSitemapExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test the behaviour of the sitemap DI extensions.
 *
 * @package DL\SitemapBundle\Tests\DependecyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class DLSitemapExtensionTest extends TestCase
{
    /**
     * @var DLSitemapExtension
     */
    protected $extension;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $containerBuilder;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->containerBuilder = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->extension = new DLSitemapExtension;
    }

    public function testGivenThatTheExtensionIsLoadedThenTheLocationPrefixWillBeInjectedFromTheSemanticConfiguration()
    {
        $configs = [
            'dl_sitemap' => [
                'location_prefix' => 'test_value',
            ]
        ];

        $this->containerBuilder
            ->expects($this->once())
            ->method('setParameter')
            ->with('sitemap_location_prefix', $configs['dl_sitemap']['location_prefix']);

        $this->extension->load($configs, $this->containerBuilder);
    }
}
