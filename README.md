# Sitemap Bundle

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/954304eb-db3a-42cc-9846-baac07fe0940/mini.png)](https://insight.sensiolabs.com/projects/954304eb-db3a-42cc-9846-baac07fe0940)
[![Total Downloads][ico-downloads]][link-downloads]

The Sitemap bundle enables development teams to quickly add support for generating sitemaps, for their PHP7 packages and projects built on Symfony 3.2+.

The bundle supports a number of customisation parameters, PSR-4 autoloading, is PSR-2 compliant and has been well tested through automated tests, as well as being used in various microservices within the Dreamlabs ecosystem.

## Install

Via Composer

``` bash
$ composer require dreamlabs/sitemap-bundle
```

Enable the bundle in your AppKernel, present in: `app/AppKernel.php`.

``` php
$bundles = [
    new DL\SitemapBundle\DLSitemapBundle(),
]
```

## Usage

In order to generate a sitemap, you need to generate an instance of sitemap definition `DL\SitemapBundle\Definition\Sitemap`.
This instance can then accept the individual sitemap resources that you would like to add via the `Sitemap::addResource()` method.

In order to assist with the generation and validation of sitemaps, the `sitemap_resource_builder` service is exposed, and can be used as in the example below:

``` php
$container->get('sitemap_resource_builder')
    ->withTitle($title)
    ->withAbsoluteLocation($location)
    ->withLastModified($lastModified) # \DateTime
    ->withChangeFrequency(ChangeFrequencyEnum::WEEKLY)
    ->withPriority(0.5)
    ->build();
```

The builder will automatically validate a new resource that is added to the Sitemap, and ensure that it is strictly valid.

The builder also exposes a `->withRelativeLocation($location)` method, which can be used alongside the `location_prefix` configuration parameter in order to generate absolute routes, from relative URLs. Given a scenarion in which the `location_prefix` parameter is set to `https://example.com` calling `->withRelativeLocation('/article/test')` will generate the absolute URL `https://example.com//article/test`.  

The `DL\SitemapBundle\Enum\ChangeFrequencyEnum` class can be used in order to define a strict change frequency. Possible values are:

* ChangeFrequencyEnum::ALWAYS
* ChangeFrequencyEnum::HOURLY
* ChangeFrequencyEnum::DAILY
* ChangeFrequencyEnum::WEEKLY
* ChangeFrequencyEnum::MONTHLY
* ChangeFrequencyEnum::YEARLY
* ChangeFrequencyEnum::NEVER

## Configuration Reference

The following configuration parameters are also available for the bundle:

``` yml
dl_sitemap:
    # The listener prefix, can be used in order to assist with the generation of absolute URLs from relative URLs.
    location_prefix: string # https://example.com
```

## Testing

``` bash
$ composer test
```

## PSR-2 Compatibility

``` bash
$ composer check-styles
$ composer fix-styles
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email petre@dreamlabs.ro instead of using the issue tracker.

## Credits

- [Petre Pătrașc][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/dlapps/sitemap-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/dlapps/sitemap-bundle/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/dlapps/sitemap-bundle.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/dlapps/sitemap-bundle.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/dlapps/sitemap-bundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/dlapps/sitemap-bundle
[link-travis]: https://travis-ci.org/dlapps/sitemap-bundle
[link-scrutinizer]: https://scrutinizer-ci.com/g/dlapps/sitemap-bundle/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/dlapps/sitemap-bundle
[link-downloads]: https://packagist.org/packages/dlapps/sitemap-bundle
[link-author]: https://github.com/petrepatrasc
[link-contributors]: ../../contributors
