<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\Bookmark\UpdateBookmarkCommand;
use App\Domain\Exception\DuplicateException;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Infrastructure\Helper\RoutingTrait;
use App\Infrastructure\Helper\SecurityTrait;
use App\Ui\Form\Type\Bookmark\UpdateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EditAction
{
    use SecurityTrait;
    use RoutingTrait;

    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

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
     * @param BookmarkRepositoryInterface   $bookmarkRepository
     * @param CommandBus                    $commandBus
     * @param FormFactoryInterface          $formFactory
     * @param EngineInterface               $engine
     * @param RouterInterface               $router
     * @param FlashBagInterface             $flashBag
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
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
     * @param int     $bookmarkId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $boardId, int $collectionId, int $bookmarkId)
    {
        $bookmark = $this->bookmarkRepository->findOneById($bookmarkId, $collectionId, $boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_WRITE', $bookmark->getCollection()->getBoard());

        $command = UpdateBookmarkCommand::createFromBookmark($bookmark);
        $form = $this->formFactory->create(UpdateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'Le favoris a été modifié.');

            return $this->redirectToRoute('collection', [
                'boardId' => $boardId,
                'collectionId' => $collectionId,
            ]);
        }

        return $this->engine->renderResponse('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'board' => $bookmark->getCollection()->getBoard(),
            'form' => $form->createView(),
        ]);
    }
}
