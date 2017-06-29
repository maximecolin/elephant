<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\Bookmark\CreateBookmarkCommand;
use App\Domain\Exception\DuplicateException;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Ui\Form\Type\Bookmark\CreateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class AddAction
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
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
        $this->collectionRepository = $collectionRepository;
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
        $collection = $this->collectionRepository->findOneById($collectionId);
        $command = new CreateBookmarkCommand(null, null, $collection->getId());
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

            try {
                $this->commandBus->handle($command);
                $this->flashBag->add('inverse', 'Votre favoris a été ajouté.');

                return new RedirectResponse($this->router->generate('collection', [
                    'boardId' => $boardId,
                    'collectionId' => $collection->getId(),
                ]));
            } catch (DuplicateException $exception) {
                $this->flashBag->add('inverse', $exception->getMessage());
            }
        }

        return $this->engine->renderResponse('bookmark/add.html.twig', [
            'collection' => $collection,
            'form' => $form->createView(),
        ]);
    }
}
