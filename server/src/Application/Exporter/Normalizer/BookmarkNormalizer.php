<?php

namespace App\Application\Exporter\Normalizer;

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
            'title' => $bookmark->getTitle(),
            'url' => $bookmark->getUrl(),
        ];
    }

    /**
     * @param array $data
     *
     * @return Bookmark
     */
    public function denormalize(array $data)
    {
        return new Bookmark(
            $data['title'],
            $data['url']
        );
    }
}
