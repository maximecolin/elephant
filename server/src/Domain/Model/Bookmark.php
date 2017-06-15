<?php

namespace App\Domain\Model;

class Bookmark
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * Bookmark constructor.
     *
     * @param string          $url
     * @param string          $title
     * @param Collection|null $collection
     */
    public function __construct(string $url, string $title, Collection $collection = null)
    {
        $this->url        = $url;
        $this->title      = $title;
        $this->collection = $collection;
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
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Get collection
     *
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param string $url
     * @param string $title
     *
     * @return $this
     */
    public function update(string $url, string $title)
    {
        $this->url = $url;
        $this->title = $title;

        return $this;
    }

    /**
     * @param Collection $collection
     *
     * @return $this
     */
    public function moveTo(Collection $collection)
    {
        $this->collection = $collection;

        return $this;
    }
}
