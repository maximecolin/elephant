<?php

/*
 * This file is part of the Developr project.
 *
 * Copyright (C) 2015 Maxime Colin
 *
 * @author Maxime Colin <contact@maximecolin.fr>
 */

namespace App\Infrastructure\Form\Transformer;

use App\Infrastructure\File\SymfonyUploadedFile;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null === $value) {
            return $value;
        }

        if ($value instanceof  SymfonyUploadedFile) {
            return $value->getFile();
        }

        throw new TransformationFailedException('Unable to transform.');
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (null === $value) {
            return $value;
        }

        if ($value instanceof UploadedFile) {
            return new SymfonyUploadedFile($value);
        }

        throw new TransformationFailedException('Unable to transform.');
    }
}

