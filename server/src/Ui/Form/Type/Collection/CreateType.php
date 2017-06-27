<?php

namespace App\Ui\Form\Type\Collection;

use App\Application\Command\CreateCollectionCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateType extends AbstractCollectionType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', CreateCollectionCommand::class);
    }
}
