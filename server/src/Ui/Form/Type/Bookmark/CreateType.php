<?php

namespace App\Ui\Form\Type\Bookmark;

use App\Application\Command\Bookmark\CreateBookmarkCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateType extends AbstractBookmarkType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', CreateBookmarkCommand::class);
    }
}
