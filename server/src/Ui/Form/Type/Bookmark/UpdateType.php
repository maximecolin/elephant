<?php

namespace App\Ui\Form\Type\Bookmark;

use App\Application\Command\UpdateBookmarkCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateType extends AbstractBookmarkType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', UpdateBookmarkCommand::class);
    }
}
