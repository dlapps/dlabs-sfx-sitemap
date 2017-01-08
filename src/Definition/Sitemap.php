<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Definition;

use DL\SitemapBundle\Exception\SitemapException;

/**
 * The representation of an entire sitemap collection.
 *
 * @package DL\SitemapBundle\Definition
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class Sitemap
{
    /**
     * The resources that make up the sitemap collection.
     *
     * @see SitemapResource
     * @var array
     */
    protected $resources;

    /**
     * Sitemap constructor.
     *
     * @param array $entries
     */
    public function __construct(array $entries = [])
    {
        $this->validateSitemapResources($entries);

        $this->resources = $entries;
    }

    /**
     * Add a new sitemap entry into the sitemap collection.
     *
     * @param SitemapResource $sitemapResource
     *
     * @return Sitemap
     */
    public function addResource(SitemapResource $sitemapResource): Sitemap
    {
        $this->resources[] = $sitemapResource;

        return $this;
    }

    /**
     * Retrieve all of the sitemap resources that have
     * been associated to the collection.
     *
     * @see SitemapResource
     * @return array
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * Validate that an array of sitemap resources is valid.
     *
     * @param array $sitemapResources
     *
     * @throws SitemapException
     */
    protected function validateSitemapResources(array $sitemapResources): void
    {
        foreach ($sitemapResources as $resource) {
            if (false === $resource instanceof SitemapResource) {
                throw new SitemapException('Invalid resource provided for sitemap collection instantiation');
            }
        }
    }
}
