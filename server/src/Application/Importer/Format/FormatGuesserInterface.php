<?php

namespace App\Application\Importer\Format;

use App\Domain\File\FileInterface;

interface FormatGuesserInterface
{
    /**
     * @param FileInterface $file
     *
     * @return string
     */
    public function guess(FileInterface $file) : string;
}

