<?php

namespace App\Application\Query;

class UserAutocompleteQuery
{
    /**
     * @var string
     */
    public $term;

    /**
     * @var int
     */
    public $boardId;

    /**
     * UserAutocompleteQuery constructor.
     *
     * @param string $term
     * @param int    $boardId
     */
    public function __construct(string $term, int $boardId)
    {
        $this->term = $term;
        $this->boardId = $boardId;
    }
}
