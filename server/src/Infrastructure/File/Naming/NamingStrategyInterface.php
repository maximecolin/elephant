<?php

namespace App\Infrastructure\File\Naming;

interface NamingStrategyInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function getName(string $name) : string;
}
