<?php

namespace App\Domain\Exception;

use Throwable;

class DomainException extends \Exception
{
    /**
     * DomainException constructor.
     *
     * @param string         $message
     * @param Throwable|null $previous
     * @param int            $code
     */
    public function __construct($message = "", Throwable $previous = null, $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
