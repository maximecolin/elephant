<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\Collection\ImportCommand;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Infrastructure\Helper\RoutingTrait;
use App\Ui\Form\Type\Collection\ImportType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class ImportAction
{
    use RoutingTrait;

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * ImportAction constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CommandBus               $commandBus
     * @param FormFactoryInterface     $formFactory
     * @param FlashBagInterface        $flashBag
     * @param RouterInterface          $router
     * @param EngineInterface          $engine
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        EngineInterface $engine
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->engine = $engine;
    }

    /**
     * @param Request $request
     * @param int     $boardId
     * @param int     $collectionId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $boardId, int $collectionId)
    {
        $collection = $this->collectionRepository->findOneById($collectionId, $boardId);

        $command = new ImportCommand($collection);
        $form = $this->formFactory->create(ImportType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'Votre fichier a été importé.');

            return $this->redirectToRoute('collection', ['boardId' => $boardId, 'collectionId' => $collectionId]);
        }

        return $this->engine->renderResponse('collection/import.html.twig', [
            'form'         => $form->createView(),
            'boardId'      => $boardId,
            'collectionId' => $collectionId,
            'collection'   => $collection,
            'board'        => $collection->getBoard(),
        ]);
    }
}
