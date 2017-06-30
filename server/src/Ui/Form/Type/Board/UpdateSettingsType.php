<?php

namespace App\Ui\Form\Type\Board;

use App\Application\Command\Board\UpdateSettingsCommand;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateSettingsType extends AbstractBoardType
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
        $resolver->setDefault('data_class', UpdateSettingsCommand::class);
    }
}
