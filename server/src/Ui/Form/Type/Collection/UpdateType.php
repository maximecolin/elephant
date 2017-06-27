<?php

namespace App\Ui\Form\Type\Collection;

use App\Application\Command\UpdateCollectionCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateType extends AbstractCollectionType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', UpdateCollectionCommand::class);
    }
}
