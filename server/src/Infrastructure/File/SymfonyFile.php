<?php

/*
 * This file is part of the Developr project.
 *
 * Copyright (C) 2015 Maxime Colin
 *
 * @author Maxime Colin <contact@maximecolin.fr>
 */

namespace App\Infrastructure\File;

use App\Domain\File\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SymfonyFile implements FileInterface
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * SymfonyUploadedFile constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     */
    public function move(string $directory, $name = null)
    {
        $this->file->move($directory, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getClientOriginalName() : string
    {
        return $this->file->getClientOriginalName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
        return $this->file->getRealPath();
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeType() : string
    {
        return $this->file->getClientMimeType();
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return file_get_contents($this->getPath());
    }
}
