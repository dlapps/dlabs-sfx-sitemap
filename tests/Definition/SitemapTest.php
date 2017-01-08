<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\Definition;

use DL\SitemapBundle\Definition\Sitemap;
use DL\SitemapBundle\Definition\SitemapResource;
use DL\SitemapBundle\Enum\ChangeFrequencyEnum;
use DL\SitemapBundle\Exception\SitemapException;
use PHPUnit\Framework\TestCase;

/**
 * Test the behaviour of sitemap collections.
 *
 * @package DL\SitemapBundle\Tests\Definition
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapTest extends TestCase
{
    public function testGivenThatADefaultSitemapIsGeneratedThenItShallContainNoAttachedResources(): void
    {
        $sitemap   = new Sitemap;
        $resources = $sitemap->getResources();

        $this->assertInternalType('array', $resources);
        $this->assertCount(0, $resources);
    }

    public function testGivenThatASitemapIsGeneratedFromAnArrayOfInvalidResourcesThenAnExceptionWillBeThrown(): void
    {
        $resources = [
            'invalid-test',
            111,
            false
        ];

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage('Invalid resource provided for sitemap collection instantiation');

        new Sitemap($resources);
    }

    public function testGivenThatASitemapIsGeneratedFromAnArrayOfValidResourcesThenTheyWillBeCorrectlyAttachedToTheResource(): void
    {
        $sitemapResource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $resources = [$sitemapResource];
        $sitemap   = new Sitemap($resources);

        $this->assertInternalType('array', $sitemap->getResources());
        $this->assertCount(1, $sitemap->getResources());
        $this->assertEquals($resources, $sitemap->getResources());
    }

    public function testGivenThatASitemapResourceIsAttachedToASitemapCollectionThenItWillBeRetrievable(): void
    {
        $sitemapResource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $sitemap = (new Sitemap)
            ->addResource($sitemapResource);

        $this->assertInternalType('array', $sitemap->getResources());
        $this->assertCount(1, $sitemap->getResources());
        $this->assertEquals($sitemapResource, $sitemap->getResources()[0]);
    }

    /**
     * @param mixed $sitemapResource
     *
     * @dataProvider invalidTypeDataProvider
     */
    public function testGivenThatAnInvalidTypeIsAttachedToASitemapCollectionThenAnExceptionWillBeThrown($sitemapResource): void
    {
        $this->expectException(\TypeError::class);

        (new Sitemap)->addResource($sitemapResource);
    }

    public function invalidTypeDataProvider(): array
    {
        return [
            ['invalid-type'],
            [123],
            [false],
            [null]
        ];
    }
}
