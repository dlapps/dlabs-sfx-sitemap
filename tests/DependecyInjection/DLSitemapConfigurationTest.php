<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\DependecyInjection;

use DL\SitemapBundle\DependencyInjection\DLSitemapConfiguration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\ScalarNode;

/**
 * Test the behaviour of the sitemap configuration DI class.
 *
 * @package DL\SitemapBundle\Tests\DependecyInjection
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class DLSitemapConfigurationTest extends TestCase
{
    /**
     * @var DLSitemapConfiguration
     */
    protected $sitemapConfiguration;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->sitemapConfiguration = new DLSitemapConfiguration;
    }

    public function testGivenThatTheTreeIsGeneratedThenASetOfSemanticConfigurationEntriesWillBeCustomisable()
    {
        /** @var ArrayNode $tree */
        $tree     = $this->sitemapConfiguration->getConfigTreeBuilder()->buildTree();
        $children = $tree->getChildren();

        $this->assertArrayHasKey('location_prefix', $children);
    }

    public function testGivenThatTheTreeIsGeneratedThenTheLocationPrefixWillContainADefaultEmptyValue()
    {
        /** @var ArrayNode $tree */
        $tree     = $this->sitemapConfiguration->getConfigTreeBuilder()->buildTree();
        $children = $tree->getChildren();

        /** @var ScalarNode $locationPrefix */
        $locationPrefix = $children['location_prefix'];
        $this->assertInstanceOf(ScalarNode::class, $locationPrefix);
        $this->assertEquals('', $locationPrefix->getDefaultValue());
    }
}
