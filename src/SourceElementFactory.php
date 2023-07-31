<?php

namespace Sven\CommonMark\ImageMediaQueries;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use Sven\CommonMark\ImageMediaQueries\Node\Source;

final class SourceElementFactory
{
    public function __construct(private readonly Collection $shorthandCollection)
    {
    }

    public function createFromImage(Image $image): Source
    {
        $query = $this->getMediaQuery($image);
        $source = new Source($image->getUrl(), $query);

        $source->data->importData($image->data);

        return $source;
    }

    private function getMediaQuery(Image $image): string
    {
        if ($image->data->has('attributes/media')) {
            /** @phpstan-ignore-next-line */
            return $image->data->get('attributes/media');
        }

        foreach ($this->shorthandCollection->attributes() as $attribute) {
            if ($image->data->has('attributes/'.$attribute)) {
                /** @var string $value */
                $value = $image->data->get('attributes/'.$attribute);
                $query = $this->shorthandCollection->get($attribute);

                return str_replace('{}', $value, $query);
            }
        }

        throw new \RuntimeException('No media query could be determined for image.');
    }
}
