<?php

namespace App\Domain\Model;

class Collaborator
{
    const LEVEL_OWNER = 'owner';
    const LEVEL_WRITE = 'write';
    const LEVEL_READ  = 'read';

    /**
     * @var User
     */
    private $user;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var string
     */
    private $level;

    /**
     * Collaboration constructor.
     *
     * @param User   $user
     * @param Board  $board
     * @param string $level
     */
    public function __construct(User $user, Board $board, string $level)
    {
        $this->user  = $user;
        $this->board = $board;
        $this->level  = $level;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Collaborator
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOwner() : bool
    {
        return self::LEVEL_OWNER === $this->level;
    }
}
