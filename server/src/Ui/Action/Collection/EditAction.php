<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\Collection\UpdateCollectionCommand;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Ui\Form\Type\Collection\UpdateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class EditAction
{
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
     * @var EngineInterface
     */
    private $engine;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * AddAction constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CommandBus                    $commandBus
     * @param FormFactoryInterface          $formFactory
     * @param EngineInterface               $engine
     * @param RouterInterface               $router
     * @param FlashBagInterface             $flashBag
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router,
        FlashBagInterface $flashBag
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
        $this->flashBag = $flashBag;
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
        $command = UpdateCollectionCommand::createFromCollection($collection);
        $form = $this->formFactory->create(UpdateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'La collection a été modifié.');

            return new RedirectResponse($this->router->generate('collection', [
                'boardId' => $boardId,
                'collectionId' => $collection->getId(),
            ]));
        }

        return $this->engine->renderResponse('collection/edit.html.twig', [
            'collection' => $collection,
            'board' => $collection->getBoard(),
            'form' => $form->createView(),
        ]);
    }
}
