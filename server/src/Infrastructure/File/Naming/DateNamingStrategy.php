<?php

namespace App\Infrastructure\File\Naming;

use Behat\Transliterator\Transliterator;

class DateNamingStrategy implements NamingStrategyInterface
{
    /**
     * @var \DateTimeInterface
     */
    private $dateTime;

    /**
     * DateNamingStrategy constructor.
     *
     * @param \DateTimeInterface $dateTime
     */
    public function __construct(\DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(string $name) : string
    {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $basename  = pathinfo($name, PATHINFO_FILENAME);

        return
            DIRECTORY_SEPARATOR .
            'uploads' .
            DIRECTORY_SEPARATOR .
            $this->dateTime->format('Y') .
            DIRECTORY_SEPARATOR .
            $this->dateTime->format('m') .
            DIRECTORY_SEPARATOR .
            uniqid() . '_' . Transliterator::urlize($basename) . '.' . $extension;
    }
}
