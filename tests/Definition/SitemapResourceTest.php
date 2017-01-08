<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\Definition;

use DL\SitemapBundle\Definition\SitemapResource;
use DL\SitemapBundle\Enum\ChangeFrequencyEnum;
use PHPUnit\Framework\TestCase;

/**
 * Test the behaviour of sitemap resources.
 *
 * @package DL\SitemapBundle\Tests\Definition
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResourceTest extends TestCase
{
    public function testGivenThatASitemapResourceIsInstantiatedThenAllOfItsFieldsWillBeMappedCorrectly(): void
    {
        $lastModifiedTime = new \DateTime;
        $resource         = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            $lastModifiedTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $this->assertEquals('Test Title', $resource->getTitle());
        $this->assertEquals('https://test.example.com', $resource->getLocation());
        $this->assertEquals($lastModifiedTime, $resource->getLastModified());
        $this->assertEquals(ChangeFrequencyEnum::ALWAYS, $resource->getChangeFrequency());
        $this->assertEquals(1.0, $resource->getPriority());
    }
}
