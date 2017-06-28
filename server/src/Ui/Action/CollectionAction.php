<?php

namespace App\Ui\Action;

use App\Application\Query\CollectionViewQuery;
use App\Domain\Exception\ModelNotFoundException;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CollectionAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollectionAction constructor.
     *
     * @param CommandBus      $commandBus
     * @param EngineInterface $engine
     */
    public function __construct(
        CommandBus $commandBus,
        EngineInterface $engine
    ) {
        $this->commandBus = $commandBus;
        $this->engine = $engine;
    }

    /**
     * @param int $collectionId
     *
     * @return string
     */
    public function __invoke(int $collectionId)
    {
        $collection = $this->commandBus->handle(new CollectionViewQuery($collectionId));

        return $this->engine->renderResponse('collection.html.twig', [
            'collection' => $collection,
        ]);
    }
}
