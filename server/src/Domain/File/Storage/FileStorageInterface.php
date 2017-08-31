<?php

namespace App\Domain\File\Storage;

use App\Domain\File\UploadedFileInterface;

interface FileStorageInterface
{
    /**
     * @param UploadedFileInterface $file
     *
     * @return string
     */
    public function add(UploadedFileInterface $file) : string;

    /**
     * @param string $filename
     */
    public function remove(string $filename);
}
