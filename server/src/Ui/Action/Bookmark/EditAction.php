<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\Bookmark\UpdateBookmarkCommand;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Ui\Form\Type\Bookmark\UpdateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class EditAction
{
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
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param CommandBus                  $commandBus
     * @param FormFactoryInterface        $formFactory
     * @param EngineInterface             $engine
     * @param RouterInterface             $router
     * @param FlashBagInterface           $flashBag
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router,
        FlashBagInterface $flashBag
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
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
     * @param int     $id
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $boardId, int $collectionId, int $id)
    {
        $bookmark = $this->bookmarkRepository->findOneById($id);

        if ($bookmark->getCollection()->getId() !== $collectionId) {
            throw new NotFoundHttpException('Bookmark not found.');
        }

        $command = UpdateBookmarkCommand::createFromBookmark($bookmark);
        $form = $this->formFactory->create(UpdateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'Le favoris a été modifié.');

            return new RedirectResponse($this->router->generate('collection', [
                'boardId' => $boardId,
                'collectionId' => $collectionId,
            ]));
        }

        return $this->engine->renderResponse('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form->createView(),
        ]);
    }
}
