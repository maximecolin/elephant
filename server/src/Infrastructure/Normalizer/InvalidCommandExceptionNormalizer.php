<?php

namespace App\Infrastructure\Normalizer;

use League\Tactician\Bundle\Middleware\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationInterface;

class InvalidCommandExceptionNormalizer
{
    /**
     * @param InvalidCommandException $exception
     *
     * @return array
     */
    public function normalize(InvalidCommandException $exception)
    {
        return [
            'errors' => array_map(function (ConstraintViolationInterface $violation) {
                return [
                    'message' => $violation->getMessage(),
                    'path' => $violation->getPropertyPath(),
                ];
            }, iterator_to_array($exception->getViolations()))
        ];
    }
}
