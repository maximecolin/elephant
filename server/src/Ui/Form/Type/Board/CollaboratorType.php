<?php

namespace App\Ui\Form\Type\Board;

use App\Domain\Model\Collaborator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class CollaboratorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', ChoiceType::class, [
                'choices' => [
                    Collaborator::LEVEL_OWNER => Collaborator::LEVEL_OWNER,
                    Collaborator::LEVEL_WRITE => Collaborator::LEVEL_WRITE,
                    Collaborator::LEVEL_READ => Collaborator::LEVEL_READ,
                ]
            ])
        ;
    }
}
