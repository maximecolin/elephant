<?php

namespace App\Domain\File\Storage;

use App\Domain\File\FileInterface;

interface FileStorageInterface
{
    /**
     * @param FileInterface $file
     *
     * @return string
     */
    public function add(FileInterface $file) : string;

    /**
     * @param string $filename
     */
    public function remove(string $filename);
}
