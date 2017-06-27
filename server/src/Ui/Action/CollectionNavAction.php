<?php

namespace App\Ui\Action;

use App\Application\Query\CollectionNavQuery;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CollectionNavAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollectionNavAction constructor.
     *
     * @param CommandBus $commandBus
     * @param RequestStack                  $requestStack
     * @param EngineInterface               $engine
     */
    public function __construct(
        CommandBus $commandBus,
        RequestStack $requestStack,
        EngineInterface $engine)
    {
        $this->commandBus = $commandBus;
        $this->engine = $engine;
        $this->requestStack = $requestStack;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $collectionId = $this->requestStack->getMasterRequest()->attributes->getInt('collectionId');
        $collections = $this->commandBus->handle(new CollectionNavQuery($collectionId));

        return $this->engine->renderResponse('collection-nav.html.twig', [
            'collections' => $collections,
        ]);
    }
}
