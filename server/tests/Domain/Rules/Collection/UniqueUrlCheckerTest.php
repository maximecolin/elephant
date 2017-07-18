<?php

namespace Tests\Domain\Rules\Collection;

use App\Domain\Exception\DuplicateException;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\Collection;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Collection\UniqueTitleChecker;
use PHPUnit\Framework\TestCase;

class UniqueTitleCheckerTest extends TestCase
{
    /**
     * @param int    $id
     * @param string $title
     *
     * @return Collection
     */
    private function createCollection(int $id, string $title)
    {
        $collection = new Collection(new Board('board'), $title);

        $reflector = new \ReflectionObject($collection);
        $property = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($collection, $id);
        $property->setAccessible(false);

        return $collection;
    }

    public function testIsUniqueExists()
    {
        $title = 'title';
        $collection = $this->createCollection(142, $title);

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willReturn($collection);

        $checker = new UniqueTitleChecker($collectionRepository->reveal());

        $this->assertTrue($checker->isUnique($title, 142));
    }

    public function testIsUniqueNotExists()
    {
        $title = 'title';

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willThrow(new ModelNotFoundException());

        $checker = new UniqueTitleChecker($collectionRepository->reveal());

        $this->assertTrue($checker->isUnique($title));
    }

    public function testNotIsUnique()
    {
        $title = 'title';
        $collection = $this->createCollection(142, $title);

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willReturn($collection);

        $checker = new UniqueTitleChecker($collectionRepository->reveal());

        $this->assertFalse($checker->isUnique($title, 123));
    }

    public function testCheckSuccess()
    {
        $title = 'title';
        $collection = $this->createCollection(142, $title);

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willThrow(new ModelNotFoundException());

        $checker = new UniqueTitleChecker($collectionRepository->reveal());
        $checker->check($collection);
    }

    public function testCheckFound()
    {
        $title = 'title';
        $collection = $this->createCollection(142, $title);

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willReturn($collection);

        $checker = new UniqueTitleChecker($collectionRepository->reveal());
        $checker->check($collection);
    }

    public function testCheckFail()
    {
        $this->expectException(DuplicateException::class);

        $title = 'title';
        $collection = $this->createCollection(142, $title);
        $collection2 = $this->createCollection(123, $title);

        $collectionRepository = $this->prophesize(CollectionRepositoryInterface::class);
        $collectionRepository->findOneByTitle($title)->shouldBeCalled()->willReturn($collection2);

        $checker = new UniqueTitleChecker($collectionRepository->reveal());
        $checker->check($collection);
    }
}
