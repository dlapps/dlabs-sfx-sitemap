<?php
declare(strict_types = 1);

namespace DL\SitemapBundle\Enum;

use DL\SitemapBundle\Definition\SitemapResource;

/**
 * Defines possible values for sitemap change frequencies.
 *
 * @see     SitemapResource
 * @package DL\SitemapBundle\Enum
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 */
final class ChangeFrequencyEnum
{
    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';
}
