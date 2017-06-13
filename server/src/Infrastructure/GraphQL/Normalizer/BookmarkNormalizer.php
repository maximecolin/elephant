<?php

namespace App\Infrastructure\GraphQL\Normalizer;

use App\Domain\Model\Bookmark;

class BookmarkNormalizer
{
    /**
     * @param Bookmark $bookmark
     *
     * @return array
     */
    public function normalize(Bookmark $bookmark) : array
    {
        return [
            'id' => $bookmark->getId(),
            'url' => $bookmark->getUrl(),
            'title' => $bookmark->getTitle(),
        ];
    }
}
