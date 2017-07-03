<?php

namespace App\Ui\Form\Type\Board;

use App\Application\Command\Board\UpdateCollaboratorsCommand;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollaboratorsType extends AbstractBoardType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('collaborators', CollectionType::class, [
                'entry_type' => CollaboratorType::class
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', UpdateCollaboratorsCommand::class);
    }
}
