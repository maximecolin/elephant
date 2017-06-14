<?php

namespace App\Infrastructure\GraphQL\Normalizer;

use App\Domain\Model\Collection;

class CollectionNormalizer
{
    /**
     * @param Collection $collection
     *
     * @return array
     */
    public function normalize(Collection $collection) : array
    {
        return [
            'id' => $collection->getId(),
            'title' => $collection->getTitle(),
        ];
    }
}
