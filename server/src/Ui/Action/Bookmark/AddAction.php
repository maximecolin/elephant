<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\Bookmark\CreateBookmarkCommand;
use App\Domain\Exception\DuplicateException;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Infrastructure\Helper\RoutingTrait;
use App\Infrastructure\Helper\SecurityTrait;
use App\Ui\Form\Type\Bookmark\CreateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AddAction
{
    use SecurityTrait;
    use RoutingTrait;

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

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
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * AddAction constructor.
     *
     * @param BoardRepositoryInterface      $boardRepository
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CommandBus                    $commandBus
     * @param FormFactoryInterface          $formFactory
     * @param EngineInterface               $engine
     * @param RouterInterface               $router
     * @param FlashBagInterface             $flashBag
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        CollectionRepositoryInterface $collectionRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->boardRepository = $boardRepository;
        $this->collectionRepository = $collectionRepository;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->authorizationChecker = $authorizationChecker;
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
        $board = $this->boardRepository->findOneById($boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_WRITE', $board);
        
        $collection = $this->collectionRepository->findOneById($collectionId);
        $command = new CreateBookmarkCommand(null, null, $collection->getId());
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

            try {
                $this->commandBus->handle($command);
                $this->flashBag->add('inverse', 'Votre favoris a été ajouté.');

                return $this->redirectToRoute('collection', [
                    'boardId' => $boardId,
                    'collectionId' => $collection->getId(),
                ]);
            } catch (DuplicateException $exception) {
                $this->flashBag->add('inverse', $exception->getMessage());
            }
        }

        return $this->engine->renderResponse('bookmark/add.html.twig', [
            'board' => $board,
            'collection' => $collection,
            'form' => $form->createView(),
        ]);
    }
}
