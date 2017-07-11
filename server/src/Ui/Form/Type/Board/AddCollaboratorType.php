<?php

namespace App\Ui\Form\Type\Board;

use App\Application\Command\Board\AddCollaboratorCommand;
use App\Domain\Model\Board;
use App\Ui\Form\Type\UserAutocompleteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCollaboratorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', UserAutocompleteType::class, [
                'autocomplete_params' => ['boardId' => $options['board']->getId()],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', AddCollaboratorCommand::class);
        $resolver->setRequired('board');
        $resolver->setAllowedTypes('board', [Board::class]);
    }
}
