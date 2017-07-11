<?php

namespace App\Ui\Form\Type;

use App\Domain\Repository\UserRepositoryInterface;
use App\Ui\Form\DataTransformer\UserToIdDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAutocompleteType extends AbstractType
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserAutocompleteType constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new UserToIdDataTransformer($this->userRepository));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'error_bubbling' => false, // Prevent hidden type to bubble error to the root form
            'autocomplete_path' => 'api_user_autocomplete',
            'autocomplete_params' => [],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['autocomplete_path'] = $options['autocomplete_path'];
        $view->vars['autocomplete_params'] = $options['autocomplete_params'];
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user_autocomplete';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return HiddenType::class;
    }
}
