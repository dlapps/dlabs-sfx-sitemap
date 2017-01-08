<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Definition;

use DL\SitemapBundle\Enum\ChangeFrequencyEnum;

/**
 * Defines a resource within a sitemap collection.
 *
 * @see     Sitemap
 * @package DL\SitemapBundle\Definition
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResource
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
     * SitemapResource constructor.
     *
     * @param string    $title
     * @param string    $location
     * @param \DateTime $lastModified
     * @param string    $changeFrequency
     * @param float     $priority
     */
    public function __construct(
        string $title,
        string $location,
        \DateTime $lastModified,
        string $changeFrequency,
        float $priority
    ) {
        $this->title           = $title;
        $this->location        = $location;
        $this->lastModified    = $lastModified;
        $this->changeFrequency = $changeFrequency;
        $this->priority        = $priority;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    /**
     * @return string
     */
    public function getChangeFrequency(): string
    {
        return $this->changeFrequency;
    }

    /**
     * @return float
     */
    public function getPriority(): float
    {
        return $this->priority;
    }
}
