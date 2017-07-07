<?php

namespace App\Ui\Api;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserAutocompleteAction
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserAutocompleteAction constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        if (!$request->query->has('term')) {
            throw new BadRequestHttpException('Missing term.');
        }

        $term = $request->query->get('term');
        $users = $this->userRepository->findByTerm($term);

        $results = array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'name' => (string) $user,
                'email' => $user->getEmail(),
            ];
        }, $users);

        return new JsonResponse($results);
    }
}
