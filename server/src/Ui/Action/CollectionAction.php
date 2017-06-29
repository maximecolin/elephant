<?php

namespace App\Ui\Action;

use App\Application\Query\CollectionViewQuery;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

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
     * @param int $boardId
     * @param int $collectionId
     *
     * @return string
     */
    public function __invoke(int $boardId, int $collectionId)
    {
        $collection = $this->commandBus->handle(new CollectionViewQuery($collectionId));

        return $this->engine->renderResponse('collection.html.twig', [
            'boardId'    => $boardId,
            'collection' => $collection,
        ]);
    }
}
