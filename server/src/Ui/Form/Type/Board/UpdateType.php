<?php

namespace App\Ui\Form\Type\Board;

use App\Application\Command\Board\UpdateBoardCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateType extends AbstractBoardType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', UpdateBoardCommand::class);
    }
}
