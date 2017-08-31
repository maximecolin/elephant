<?php

/*
 * This file is part of the Developr project.
 *
 * Copyright (C) 2015 Maxime Colin
 *
 * @author Maxime Colin <contact@maximecolin.fr>
 */

namespace App\Infrastructure\File\Storage;

use App\Domain\File\Storage\FileStorageInterface;
use App\Domain\File\UploadedFileInterface;
use App\Infrastructure\File\Naming\NamingStrategyInterface;

class LocalFileStorageAdapter implements FileStorageInterface
{
    /**
     * @var string
     */
    private $rootPath;

    /**
     * @var NamingStrategyInterface
     */
    private $namingStrategy;

    /**
     * @param string                  $rootPath
     * @param NamingStrategyInterface $namingStrategy
     */
    public function __construct(string $rootPath, NamingStrategyInterface $namingStrategy)
    {
        $this->rootPath       = $rootPath;
        $this->namingStrategy = $namingStrategy;
    }

    /**
     * {@inheritdoc}
     */
    public function add(UploadedFileInterface $file) : string
    {
        $filepath = $this->namingStrategy->getName($file->getClientOriginalName());
        $file->move($this->rootPath . pathinfo($filepath, PATHINFO_DIRNAME), pathinfo($filepath, PATHINFO_BASENAME));

        return $filepath;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $filepath)
    {
        $path = $this->rootPath . $filepath;

        if (file_exists($path) && is_file($path)) {
            unlink($path);
        }
    }
}
