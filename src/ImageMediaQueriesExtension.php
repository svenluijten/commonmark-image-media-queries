<?php

namespace Sven\CommonMark\ImageMediaQueries;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use Sven\CommonMark\ImageMediaQueries\Event\ImageMediaQueryListener;
use Sven\CommonMark\ImageMediaQueries\Node\Picture;
use Sven\CommonMark\ImageMediaQueries\Node\Source;
use Sven\CommonMark\ImageMediaQueries\Renderer\PictureRenderer;
use Sven\CommonMark\ImageMediaQueries\Renderer\SourceRenderer;
use Sven\CommonMark\ImageMediaQueries\Shorthands\Shorthand;

final class ImageMediaQueriesExtension implements ConfigurableExtensionInterface
{
    /**
     * @var Shorthand[]
     */
    private array $shorthands = [];

    public function register(EnvironmentBuilderInterface $environment): void
    {
        /** @phpstan-ignore-next-line */
        $extensions = $environment->getExtensions();

        $this->assertArrayContainsInstanceOf(AttributesExtension::class, $extensions);

        $environment->addEventListener(DocumentParsedEvent::class, [new ImageMediaQueryListener($this->shorthands), 'processDocument']);

        $environment->addRenderer(Picture::class, new PictureRenderer());
        $environment->addRenderer(Source::class, new SourceRenderer());
    }

    /**
     * @param  class-string  $class
     * @param  iterable<ExtensionInterface>  $extensions
     * @return void
     */
    private function assertArrayContainsInstanceOf(string $class, iterable $extensions): void
    {
        foreach ($extensions as $extension) {
            if ($extension instanceof $class) {
                return;
            }
        }

        throw new \RuntimeException('The "'.self::class.'" extension requires the "'.$class.'" extension to be loaded before it.');
    }

    public function addShorthand(Shorthand $shorthand): self
    {
        $this->shorthands[] = $shorthand;

        return $this;
    }

    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('image_media_queries', Expect::structure([
            'picture_class' => Expect::string()->default('media-query-picture'),
        ]));
    }
}
