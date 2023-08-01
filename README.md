# CommonMark Image Media Queries

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![StyleCI][ico-styleci]][link-styleci]
[![PhpStan][ico-phpstan]][link-phpstan]

This [CommonMark](https://commonmark.thephpleague.com) extension allows you to add media queries to images in your 
CommonMark-rendered Markdown.

## Installation
You can install this extension [via Composer](http://getcomposer.org):

```bash
composer require sven/commonmark-image-media-queries
```

## Usage
To enable this extension, first make sure [the `Attributes` extension](https://commonmark.thephpleague.com/2.4/extensions/attributes/)
that ships with CommonMark is enabled. Then, add it to the CommonMark environment:

```php
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;

$environment->addExtension(new ImageMediaQueriesExtension());
```

You can now add the `media` attribute to your images:

```markdown
![from 800px wide](/assets/800.jpg){media="(min-width: 800px)"}
![from 1200px wide](/assets/1200.jpg){media="(min-width: 1200px)"}
![An image](/assets/default.jpg)
```

This will render the following HTML:

```html
<picture class="media-query-picture">
    <source srcset="/assets/800.jpg" media="(min-width: 800px)" />
    <source srcset="/assets/1200.jpg" media="(min-width: 1200px)" />
    <img src="/assets/default.jpg" alt="An image" />
</picture>
```

> [!IMPORTANT]
> The _last_ image directly after at least one other image with a `media` attribute will always be used as the
> "default", and will thus be rendered as the `<img />` tag in the `<picture>` element. If this last image has a `media`
> attribute itself, that attribute will not be used and be stripped away.

### Shorthands
This extension also ships with, and allows you to write your own, shorthands for often-used media queries. You can 
enable a shorthand while registering the extension with CommonMark:

```php
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;
use Sven\CommonMark\ImageMediaQueries\Shorthands\ColorScheme;

$extension = new ImageMediaQueriesExtension();
$extension->addShorthand(new ColorScheme());

$environment->addExtension($extension);
```

#### Color Scheme
The `\Sven\CommonMark\ImageMediaQueries\Shorthands\ColorScheme` shorthand allows you to use `{scheme=dark}` on an image, 
and expands into `(prefers-color-scheme: dark)`:

```markdown
![dark](/assets/dark-settings.jpg){scheme=dark}
![A settings dialog](/assets/settings.jpg)
```

This will render the following HTML:

```html
<picture class="media-query-picture">
    <source srcset="/assets/dark-settings.jpg" media="(prefers-color-scheme: dark)" />
    <img src="/assets/settings.jpg" alt="An image" />
</picture>
```

#### Width
The `\Sven\CommonMark\ImageMediaQueries\Shorthands\Width` shorthand gives you the `minw` and `maxw` attributes to add to
an image. The example from above can then be shortened to the following:

```markdown
![from 800px wide](/assets/800.jpg){minw=800px}
![from 1200px wide](/assets/1200.jpg){minw=1200px}
![An image](/assets/default.jpg)
```

This of course also works the same with `{maxw=[value]}`.

#### Writing your own
To write your own shorthand, implement the `\Sven\CommonMark\ImageMediaQueries\Shorthands\Shorthand` interface and
return an array of queries keyed by their shorthand from the `mediaQueries` method. Any instances of `{}` in the query
will be replaced by the value of the HTML attribute.

```php
use Sven\CommonMark\ImageMediaQueries\Shorthands\Shorthand;

final class AspectRatio implements Shorthand
{
    public function mediaQueries(): iterable
    {
        return [
            'min-aspect' => '(min-aspect-ratio: {})',
            'max-aspect' => '(max-aspect-ratio: {})',
        ];
    }
}
```

If you then add the shorthand to the extension, you can use attributes like `{min-aspect=8/5}` and `{max-aspect=3/2}` on
images in your Markdown.

> [!NOTE]
> You can implement the `\Sven\CommonMark\ImageMediaQueries\Shorthands\ConfigurationAwareShorthand` interface _instead_
> of the regular `Shorthand` interface if you would like access to the CommonMark configuration object.

## Configuration
By default, this extension adds the `media-query-picture` class to the `<picture>` element it renders. You can change
this class in the configuration:

```php
use League\CommonMark\Environment\Environment;
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;

$environment = new Environment([
    'image_media_queries' => [
        'picture_class' => 'your-class', // Default: 'media-query-picture'.
    ],
]);

$environment->addExtension(new ImageMediaQueriesExtension());
```

> **Note:** Remember that the `<picture>` element cannot be styled, because it is not actually rendered in the browser.
> You should style the `<img>` element instead. See [the MDN page](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/picture)
> for more information.

## Contributing
All contributions (pull requests, issues and feature requests) are welcome. Make sure to read through the
[CONTRIBUTING.md](CONTRIBUTING.md) first, though. See the [contributors page](../../graphs/contributors) for all
contributors.

## License
`sven/commonmark-image-media-queries` is licensed under the MIT License (MIT). Please see [the license file](LICENSE.md)
for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/commonmark-image-media-queries.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/commonmark-image-media-queries.svg?style=flat-square
[ico-build]: https://img.shields.io/github/actions/workflow/status/svenluijten/commonmark-image-media-queries/run-tests.yml?branch=main&style=flat-square
[ico-styleci]: https://styleci.io/repos/672279253/shield
[ico-phpstan]: https://img.shields.io/badge/phpstan-enabled-blue.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/commonmark-image-media-queries
[link-downloads]: https://packagist.org/packages/sven/commonmark-image-media-queries/stats
[link-build]: https://github.com/svenluijten/commonmark-image-media-queries/actions/workflows/run-tests.yml
[link-styleci]: https://styleci.io/repos/672279253
[link-phpstan]: https://github.com/phpstan/phpstan
