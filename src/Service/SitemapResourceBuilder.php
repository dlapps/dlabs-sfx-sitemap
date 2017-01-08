<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Service;

use DL\SitemapBundle\Definition\SitemapResource;

/**
 * Handles the construction of sitemap resources.
 *
 * @package DL\SitemapBundle\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResourceBuilder
{
    /**
     * The title of the resource.
     *
     * @var string
     */
    protected $title;

    /**
     * The absolute URL of where the resource can be accessed.
     *
     * @var string
     */
    protected $location;

    /**
     * The date at which the resource was last modified.
     *
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * The change frequency at which this resource is updated.
     *
     * @see ChangeFrequencyEnum
     * @var string
     */
    protected $changeFrequency;

    /**
     * The priority that this resource should be given within a sitemap.
     *
     * @var float
     */
    protected $priority;

    /**
     * @var SitemapResourceValidator
     */
    protected $validator;

    /**
     * The location prefix - used when creating resources
     * with relative locations.
     *
     * @var string
     */
    protected $locationPrefix;

    /**
     * SitemapResourceBuilder constructor.
     *
     * @param SitemapResourceValidator $validator
     * @param string                   $locationPrefix
     */
    public function __construct(SitemapResourceValidator $validator, string $locationPrefix)
    {
        $this->validator      = $validator;
        $this->locationPrefix = $locationPrefix;
        $this->clear();
    }

    /**
     * Clear all of the builder properties to ensure a default state
     * between multiple executions.
     */
    private function clear(): void
    {
        $this->title           = '';
        $this->location        = '';
        $this->lastModified    = null;
        $this->changeFrequency = '';
        $this->priority        = -1;
    }

    /**
     * Build an instance of a sitemap resource and validate it.
     *
     * @return SitemapResource
     */
    public function build(): SitemapResource
    {
        $resource = new SitemapResource(
            $this->title,
            $this->location,
            $this->lastModified,
            $this->changeFrequency,
            $this->priority
        );

        $this->clear();
        $this->validator->validate($resource);

        return $resource;
    }

    /**
     * @param string $title
     *
     * @return SitemapResourceBuilder
     */
    public function withTitle(string $title): SitemapResourceBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $location
     *
     * @return SitemapResourceBuilder
     */
    public function withAbsoluteLocation(string $location): SitemapResourceBuilder
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param string $location
     *
     * @return SitemapResourceBuilder
     */
    public function withRelativeLocation(string $location): SitemapResourceBuilder
    {
        $this->location = $this->locationPrefix . $location;

        return $this;
    }

    /**
     * @param string $changeFrequency
     *
     * @return SitemapResourceBuilder
     */
    public function withChangeFrequency(string $changeFrequency): SitemapResourceBuilder
    {
        $this->changeFrequency = $changeFrequency;

        return $this;
    }

    /**
     * @param \DateTime $lastModified
     *
     * @return SitemapResourceBuilder
     */
    public function withLastModified(\DateTime $lastModified): SitemapResourceBuilder
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * @param float $priority
     *
     * @return SitemapResourceBuilder
     */
    public function withPriority(float $priority): SitemapResourceBuilder
    {
        $this->priority = $priority;

        return $this;
    }
}
