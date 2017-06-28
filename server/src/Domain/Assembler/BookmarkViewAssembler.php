<?php

namespace App\Domain\Assembler;

use App\Domain\Dto\BookmarkView;
use App\Domain\Model\Bookmark;

class BookmarkViewAssembler
{
    /**
     * @param Bookmark $bookmark
     *
     * @return BookmarkView
     */
    public function assemble(Bookmark $bookmark)
    {
        return new BookmarkView(
            $bookmark->getId(),
            $bookmark->getTitle(),
            $bookmark->getUrl()
        );
    }

    /**
     * @param array $bookmarks
     *
     * @return array
     */
    public function assembleAll(array $bookmarks)
    {
        return array_map([$this, 'assemble'], $bookmarks);
    }
}
