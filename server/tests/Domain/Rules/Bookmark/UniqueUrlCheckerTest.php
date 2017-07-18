<?php

namespace Tests\Domain\Rules\Bookmark;

use App\Domain\Exception\DuplicateException;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Rules\Bookmark\UniqueUrlChecker;
use PHPUnit\Framework\TestCase;

class UniqueUrlCheckerTest extends TestCase
{
    /**
     * @param int    $id
     * @param string $url
     * @param string $title
     *
     * @return Bookmark
     */
    private function createBookmark(int $id, string $url, string $title) : Bookmark
    {
        $bookmark = new Bookmark($url, $title);

        $reflector = new \ReflectionObject($bookmark);
        $property = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($bookmark, $id);
        $property->setAccessible(false);

        return $bookmark;
    }

    public function testIsUniqueExists()
    {
        $url = 'http://www.foobar.com/';
        $bookmark = $this->createBookmark(142, $url, 'title');

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willReturn($bookmark);

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());

        $this->assertTrue($checker->isUnique($url, 142));
    }

    public function testIsUniqueNotExists()
    {
        $url = 'http://www.foobar.com/';

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willThrow(new ModelNotFoundException());

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());

        $this->assertTrue($checker->isUnique($url));
    }

    public function testNotIsUnique()
    {
        $url = 'http://www.foobar.com/';
        $bookmark = $this->createBookmark(142, $url, 'title');

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willReturn($bookmark);

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());

        $this->assertFalse($checker->isUnique($url, 123));
    }

    public function testCheckSuccess()
    {
        $url = 'http://www.foobar.com/';
        $bookmark = $this->createBookmark(142, $url, 'title');

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willThrow(new ModelNotFoundException());

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());
        $checker->check($bookmark);
    }

    public function testCheckFound()
    {
        $url = 'http://www.foobar.com/';
        $bookmark = $this->createBookmark(142, $url, 'title');

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willReturn($bookmark);

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());
        $checker->check($bookmark);
    }

    public function testCheckFail()
    {
        $this->expectException(DuplicateException::class);

        $url = 'http://www.foobar.com/';
        $bookmark = $this->createBookmark(142, $url, 'title');
        $bookmark2 = $this->createBookmark(123, $url, 'title');

        $bookmarkRepository = $this->prophesize(BookmarkRepositoryInterface::class);
        $bookmarkRepository->findOneByUrl($url)->shouldBeCalled()->willReturn($bookmark2);

        $checker = new UniqueUrlChecker($bookmarkRepository->reveal());
        $checker->check($bookmark);
    }
}
