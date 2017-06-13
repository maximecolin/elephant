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
     * Bookmark constructor.
     *
     * @param string $url
     * @param string $title
     */
    public function __construct(string $url, string $title)
    {
        $this->url   = $url;
        $this->title = $title;
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
}
