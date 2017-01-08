<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Service;

use DL\SitemapBundle\Definition\SitemapResource;
use DL\SitemapBundle\Enum\ChangeFrequencyEnum;
use DL\SitemapBundle\Exception\SitemapException;

/**
 * Handles the validation of sitemap resources.
 *
 * @package DL\SitemapBundle\Service
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
class SitemapResourceValidator
{
    /**
     * Validate a sitemap resource.
     *
     * @param SitemapResource $resource
     *
     * @return bool
     * @throws SitemapException
     */
    public function validate(SitemapResource $resource): bool
    {
        $this->validateEmptyTitle($resource);
        $this->validateEmptyLocation($resource);
        $this->validateEmptyChangeFrequency($resource);
        $this->validateEmptyPriority($resource);
        $this->validateInvalidPriority($resource);
        $this->validateInvalidChangeFrequency($resource);
        $this->validateInvalidLocation($resource);

        return true;
    }

    /**
     * Retrieve a list of the valid change frequencies.
     *
     * @return array
     */
    private function getValidChangeFrequencies(): array
    {
        return [
            ChangeFrequencyEnum::ALWAYS,
            ChangeFrequencyEnum::HOURLY,
            ChangeFrequencyEnum::DAILY,
            ChangeFrequencyEnum::WEEKLY,
            ChangeFrequencyEnum::MONTHLY,
            ChangeFrequencyEnum::YEARLY,
            ChangeFrequencyEnum::NEVER,
        ];
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateEmptyTitle(SitemapResource $resource)
    {
        if ('' === trim($resource->getTitle())) {
            throw new SitemapException('No title provided for the sitemap resource');
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateEmptyLocation(SitemapResource $resource)
    {
        if ('' === trim($resource->getLocation())) {
            throw new SitemapException('No location provided for the sitemap resource');
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateEmptyChangeFrequency(SitemapResource $resource)
    {
        if ('' === trim($resource->getChangeFrequency())) {
            throw new SitemapException('No change frequency provided for the sitemap resource');
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateEmptyPriority(SitemapResource $resource)
    {
        if (-1 == $resource->getPriority()) {
            throw new SitemapException('No priority provided for the sitemap resource');
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateInvalidPriority(SitemapResource $resource)
    {
        if ($resource->getPriority() < 0.0 || $resource->getPriority() > 1.0) {
            throw new SitemapException("Sitemap resource priority should be between 0.0 and 1.0." .
                " {$resource->getPriority()} provided.");
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateInvalidChangeFrequency(SitemapResource $resource)
    {
        if (false === in_array($resource->getChangeFrequency(), $this->getValidChangeFrequencies())) {
            throw new SitemapException("Invalid sitemap change frequency provided: {$resource->getChangeFrequency()}");
        }
    }

    /**
     * @param SitemapResource $resource
     *
     * @throws SitemapException
     */
    private function validateInvalidLocation(SitemapResource $resource)
    {
        if (false === filter_var($resource->getLocation(), FILTER_VALIDATE_URL)) {
            throw new SitemapException("Invalid absolute location: {$resource->getLocation()}");
        }
    }
}
