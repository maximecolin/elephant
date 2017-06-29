<?php

namespace App\Domain\Model;

class Collection
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var string
     */
    private $title;

    /**
     * Collection constructor.
     *
     * @param Board  $board
     * @param string $title
     */
    public function __construct(Board $board, string $title)
    {
        $this->board = $board;
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
     * Get board
     *
     * @return Board
     */
    public function getBoard()
    {
        return $this->board;
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
     * @param string $title
     *
     * @return $this
     */
    public function update(string $title)
    {
        $this->title = $title;

        return $this;
    }
}
