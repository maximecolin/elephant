<?php

namespace App\Ui\Form\Type\Bookmark;

use App\Application\Command\CreateBookmarkCommand;
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
