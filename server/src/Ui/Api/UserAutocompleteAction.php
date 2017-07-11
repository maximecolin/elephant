<?php

namespace App\Ui\Api;

use App\Application\Query\UserAutocompleteQuery;
use App\Infrastructure\Normalizer\InvalidCommandExceptionNormalizer;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserAutocompleteAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var InvalidCommandExceptionNormalizer
     */
    private $normalizer;

    /**
     * UserAutocompleteAction constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        $this->normalizer = new InvalidCommandExceptionNormalizer();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $command = new UserAutocompleteQuery(
                $request->query->get('term'),
                $request->query->getInt('boardId')
            );

            $data = $this->commandBus->handle($command);

            return new JsonResponse($data);
        } catch (InvalidCommandException $exception) {
            return new JsonResponse($this->normalizer->normalize($exception), 400);
        }
    }
}
