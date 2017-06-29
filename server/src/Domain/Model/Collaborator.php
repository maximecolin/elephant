<?php

namespace App\Domain\Model;

class Collaborator
{
    const TYPE_OWNER = 'owner';
    const TYPE_WRITE = 'write';
    const TYPE_READ  = 'read';

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
    private $type;

    /**
     * Collaboration constructor.
     *
     * @param User   $user
     * @param Board  $board
     * @param string $type
     */
    public function __construct(User $user, Board $board, string $type)
    {
        $this->user  = $user;
        $this->board = $board;
        $this->type  = $type;
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
