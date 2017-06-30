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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    Collaborator::TYPE_OWNER => Collaborator::TYPE_OWNER,
                    Collaborator::TYPE_WRITE => Collaborator::TYPE_WRITE,
                    Collaborator::TYPE_READ => Collaborator::TYPE_READ,
                ]
            ])
        ;
    }
}
