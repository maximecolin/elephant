<?php

namespace App\Domain\Dto;

class CollectionNavItem
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $bookmarks;

    /**
     * @var bool
     */
    private $active = false;

    /**
     * CollectionNavItem constructor.
     *
     * @param int    $id
     * @param string $title
     * @param int    $bookmarks
     */
    public function __construct(int $id, string $title, int $bookmarks)
    {
        $this->id = $id;
        $this->title = $title;
        $this->bookmarks = $bookmarks;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get bookmarks
     *
     * @return int
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return $this
     */
    public function markAsActive()
    {
        $this->active = true;

        return $this;
    }
}
