<?php

namespace App\Domain\Dto;

class ExportedFile
{
    /**
     * @var string
     */
    public $filepath;

    /**
     * @var string
     */
    public $filename;

    /**
     * ExportedFile constructor.
     *
     * @param string $filepath
     * @param string $filename
     */
    public function __construct(string $filepath, string $filename)
    {
        $this->filepath = $filepath;
        $this->filename = $filename;
    }
}
