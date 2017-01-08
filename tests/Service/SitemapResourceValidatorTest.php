<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\Service;

use DL\SitemapBundle\Definition\SitemapResource;
use DL\SitemapBundle\Enum\ChangeFrequencyEnum;
use DL\SitemapBundle\Exception\SitemapException;
use DL\SitemapBundle\Service\SitemapResourceValidator;
use PHPUnit\Framework\TestCase;

/**
 * Test the behaviour of the resource validator.
 *
 * @package DL\SitemapBundle\Tests\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResourceValidatorTest extends TestCase
{
    /**
     * @var SitemapResourceValidator
     */
    protected $validator;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->validator = new SitemapResourceValidator;
    }

    public function testGivenThatAValidSitemapResourceIsProvidedThenTheValidatorWillReturnAPositiveResponse(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $result = $this->validator->validate($resource);

        $this->assertInternalType('boolean', $result);
        $this->assertTrue($result);
    }

    public function testGivenThatNoTitleIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            '',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage('No title provided for the sitemap resource');

        $this->validator->validate($resource);
    }

    public function testGivenThatNoLocationIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            '',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage('No location provided for the sitemap resource');

        $this->validator->validate($resource);
    }

    public function testGivenThatNoChangeFrequencyIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            '',
            1.0
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage('No change frequency provided for the sitemap resource');

        $this->validator->validate($resource);
    }

    public function testGivenThatNoPriorityIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            -1
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage('No priority provided for the sitemap resource');

        $this->validator->validate($resource);
    }

    public function testGivenThatANegativePriorityIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            -0.1
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage("Sitemap resource priority should be between 0.0 and 1.0. -0.1 provided.");

        $this->validator->validate($resource);
    }

    public function testGivenThatAPriorityOfAboveOneIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.1
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage("Sitemap resource priority should be between 0.0 and 1.0. 1.1 provided.");

        $this->validator->validate($resource);
    }

    public function testGivenThatAnInvalidChangeFrequencyIsProvidedThenAnExceptionWillBeThrown(): void
    {
        $resource = new SitemapResource(
            'Test Title',
            'https://test.example.com',
            new \DateTime,
            'custom',
            1.0
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage("Invalid sitemap change frequency provided: custom");

        $this->validator->validate($resource);
    }

    /**
     * @param string $invalidUrl
     *
     * @dataProvider invalidLocationUrlDataProvider
     */
    public function testGivenThatAnInvalidLocationUrlIsProvidedThenAnExceptionWillBeThrown(string $invalidUrl): void
    {
        $resource = new SitemapResource(
            'Test Title',
            $invalidUrl,
            new \DateTime,
            ChangeFrequencyEnum::ALWAYS,
            1.0
        );

        $this->expectException(SitemapException::class);
        $this->expectExceptionMessage("Invalid absolute location: {$invalidUrl}");

        $this->validator->validate($resource);
    }

    public function invalidLocationUrlDataProvider(): array
    {
        return [
            ['test-invalid'],
            ['/articles/test-article'],
        ];
    }
}
