<?php

namespace App\Domain\Assembler;

use App\Domain\Dto\CollectionView;
use App\Domain\Model\Collection;

class CollectionViewAssembler
{
    /**
     * @param Collection $collection
     * @param array      $bookmarks
     *
     * @return CollectionView
     */
    public function assemble(Collection $collection, array $bookmarks)
    {
        $bookmarkAssembler = new BookmarkViewAssembler();

        return new CollectionView(
            $collection->getId(),
            $collection->getTitle(),
            $bookmarkAssembler->assembleAll($bookmarks)
        );
    }
}
