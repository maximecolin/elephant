<?php

namespace App\Application\Importer\Format;

use App\Domain\File\UploadedFileInterface;

interface FormatGuesserInterface
{
    /**
     * @param UploadedFileInterface $file
     *
     * @return string
     */
    public function guess(UploadedFileInterface $file) : string;
}

