<?php

/*
 * This file is part of the Developr project.
 *
 * Copyright (C) 2015 Maxime Colin
 *
 * @author Maxime Colin <contact@maximecolin.fr>
 */

namespace App\Infrastructure\Form\Extension;

use App\Infrastructure\Form\Transformer\UploadedFileTransformer;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class FileTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new UploadedFileTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return FileType::class;
    }
}
