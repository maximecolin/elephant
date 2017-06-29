<?php

namespace App\Ui\Form\Type\Board;

use App\Application\Command\Board\CreateBoardCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateType extends AbstractBoardType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', CreateBoardCommand::class);
    }
}
