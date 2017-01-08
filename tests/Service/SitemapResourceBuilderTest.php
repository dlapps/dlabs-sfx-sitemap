<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Tests\Service;

use DL\SitemapBundle\Definition\SitemapResource;
use DL\SitemapBundle\Enum\ChangeFrequencyEnum;
use DL\SitemapBundle\Service\SitemapResourceBuilder;
use DL\SitemapBundle\Service\SitemapResourceValidator;
use PHPUnit\Framework\TestCase;

/**
 * Test the behaviour of the resource builder.
 *
 * @package DL\SitemapBundle\Tests\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResourceBuilderTest extends TestCase
{
    /**
     * @var SitemapResourceBuilder
     */
    protected $builder;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $validator;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->validator = $this->getMockBuilder(SitemapResourceValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->builder = new SitemapResourceBuilder($this->validator, 'https://test.example.com');
    }

    public function testGivenThatTheBuilderHasOnlyBeenInstantiatedThenAllOfItsPropertiesWillContainDefaultValues()
    {
        $this->assertAttributeEquals('', 'title', $this->builder);
        $this->assertAttributeEquals('', 'location', $this->builder);
        $this->assertAttributeEquals(null, 'lastModified', $this->builder);
        $this->assertAttributeEquals('', 'changeFrequency', $this->builder);
        $this->assertAttributeEquals(-1, 'priority', $this->builder);
    }

    public function testGivenThatAnAbsoluteLocationIsProvidedThenTheLocationPrefixWillNotBeAddedToTheFinalValue()
    {
        $this->builder->withAbsoluteLocation('https://test2.example.com');

        $this->assertAttributeEquals('https://test2.example.com', 'location', $this->builder);
    }

    public function testGivenThatARelativeLocationIsProvidedThenTheLocationPrefixWillBeAddedToTheFinalValue()
    {
        $this->builder->withRelativeLocation('/article/test-article');

        $this->assertAttributeEquals('https://test.example.com/article/test-article', 'location', $this->builder);
    }

    public function testGivenThatAllFieldsAllProvidedThenAllOfThemWillBeSetInTheBuilderInstance()
    {
        $lastModified = new \DateTime;
        $this->builder
            ->withTitle('Test Title')
            ->withRelativeLocation('/test-location')
            ->withLastModified($lastModified)
            ->withChangeFrequency(ChangeFrequencyEnum::ALWAYS)
            ->withPriority(1.0);

        $this->assertAttributeEquals('Test Title', 'title', $this->builder);
        $this->assertAttributeEquals('https://test.example.com/test-location', 'location', $this->builder);
        $this->assertAttributeEquals($lastModified, 'lastModified', $this->builder);
        $this->assertAttributeEquals(ChangeFrequencyEnum::ALWAYS, 'changeFrequency', $this->builder);
        $this->assertAttributeEquals(1.0, 'priority', $this->builder);
    }

    public function testGivenThatAllFieldsAreProvidedToTheBuilderThenTheyWillBeUsedToConstructANewInstanceThatWillBePassedToTheValidator()
    {
        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $lastModified = new \DateTime;
        $resource     = $this->builder
            ->withTitle('Test Title')
            ->withRelativeLocation('/test-location')
            ->withLastModified($lastModified)
            ->withChangeFrequency(ChangeFrequencyEnum::ALWAYS)
            ->withPriority(1.0)
            ->build();

        $this->assertInstanceOf(SitemapResource::class, $resource);
        $this->assertEquals('Test Title', $resource->getTitle());
        $this->assertEquals('https://test.example.com/test-location', $resource->getLocation());
        $this->assertEquals($lastModified, $resource->getLastModified());
        $this->assertEquals(ChangeFrequencyEnum::ALWAYS, $resource->getChangeFrequency());
        $this->assertEquals(1.0, $resource->getPriority());
    }

    public function testGivenThatANewInstanceHasBeenBuiltThenTheBuilderWillResetToTheDefaultFieldValues()
    {
        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $lastModified = new \DateTime;
        $this->builder
            ->withTitle('Test Title')
            ->withRelativeLocation('/test-location')
            ->withLastModified($lastModified)
            ->withChangeFrequency(ChangeFrequencyEnum::ALWAYS)
            ->withPriority(1.0)
            ->build();

        $this->assertAttributeEquals('', 'title', $this->builder);
        $this->assertAttributeEquals('', 'location', $this->builder);
        $this->assertAttributeEquals(null, 'lastModified', $this->builder);
        $this->assertAttributeEquals('', 'changeFrequency', $this->builder);
        $this->assertAttributeEquals(-1, 'priority', $this->builder);
    }
}
