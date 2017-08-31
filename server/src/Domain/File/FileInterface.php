<?php

namespace App\Domain\File;

interface FileInterface
{
    /**
     * @param string      $directory
     * @param string|null $name
     *
     * @return mixed
     */
    public function move(string $directory, $name = null);

    /**
     * @return string
     */
    public function getClientOriginalName() : string;

    /**
     * @return string
     */
    public function getPath() : string;

    /**
     * @return string
     */
    public function getMimeType() : string;
}
