<?php

namespace Sven\CommonMark\ImageMediaQueries\Event;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\Query;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;
use Sven\CommonMark\ImageMediaQueries\AttributeHelper;
use Sven\CommonMark\ImageMediaQueries\Collection;
use Sven\CommonMark\ImageMediaQueries\Node\Picture;
use Sven\CommonMark\ImageMediaQueries\Shorthands\ConfigurationAwareShorthand;
use Sven\CommonMark\ImageMediaQueries\Shorthands\Shorthand;
use Sven\CommonMark\ImageMediaQueries\SourceElementFactory;

final class ImageMediaQueryListener implements ConfigurationAwareInterface
{
    /**
     * @var Shorthand[]
     */
    private array $shorthands;

    private ConfigurationInterface $config;

    private Collection $shorthandCollection;

    /**
     * @param  Shorthand[]  $shorthands
     */
    public function __construct(array $shorthands)
    {
        $this->shorthands = $shorthands;
        $this->shorthandCollection = new Collection();
    }

    public function processDocument(DocumentParsedEvent $event): void
    {
        foreach ($this->shorthands as $shorthand) {
            if ($shorthand instanceof ConfigurationAwareShorthand) {
                $shorthand->setConfiguration($this->config);
            }

            foreach ($shorthand->mediaQueries() as $key => $query) {
                $this->shorthandCollection->add($key, $query);
            }
        }

        $paragraphsWithRelevantImages = (new Query())
            ->where(Query::type(Paragraph::class))
            ->andWhere(Query::hasChild(function (Node $node) {
                $attrs = array_keys((array) $node->data->get('attributes'));

                return count(array_intersect($attrs, ['media', ...$this->shorthandCollection->attributes()])) > 0;
            }))
            ->findAll($event->getDocument());

        foreach ($paragraphsWithRelevantImages as $paragraph) {
            $images = $this->findAllImages($paragraph);

            /** @var Image $lastImage */
            $lastImage = array_pop($images);

            $picture = new Picture();
            $picture->data->set('attributes/class', $this->config->get('image_media_queries/picture_class'));

            $sourceElementFactory = new SourceElementFactory($this->shorthandCollection);

            foreach ($images as $image) {
                $source = $sourceElementFactory->createFromImage($image);
                $picture->appendChild($source);
            }

            $picture->appendChild($lastImage);

            foreach ($picture->children() as $child) {
                AttributeHelper::removeFromNode($child, $this->shorthandCollection->attributes());
            }

            AttributeHelper::removeFromNode($lastImage, ['media']);

            $paragraph->replaceWith($picture);
        }
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    /**
     * @param  Node  $paragraph
     * @return Image[]
     */
    protected function findAllImages(Node $paragraph): array
    {
        /** @var \Traversable<Image> $images */
        $images = (new Query())
            ->where(Query::type(Image::class))
            ->findAll($paragraph);

        return iterator_to_array($images);
    }
}
