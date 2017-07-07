<?php

namespace App\Ui\Form\DataTransformer;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserToIdDataTransformer implements DataTransformerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserToIdDataTransformer constructor.
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
    public function transform($value)
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof User) {
            throw new TransformationFailedException('Expected User instance.');
        }

        return $value->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if ($value === null) {
            return null;
        }
        
        try {
            return $this->userRepository->findOneById($value);
        } catch (ModelNotFoundException $exception) {
            throw new TransformationFailedException($exception->getMessage(), 0, $exception);
        }
    }
}
