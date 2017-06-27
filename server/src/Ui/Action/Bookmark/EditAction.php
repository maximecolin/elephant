<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\UpdateBookmarkCommand;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Ui\Form\Type\Bookmark\UpdateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * AddAction constructor.
     *
     * @param BookmarkRepositoryInterface   $bookmarkRepository
     * @param CommandBus                    $commandBus
     * @param FormFactoryInterface          $formFactory
     * @param EngineInterface               $engine
     * @param RouterInterface               $router
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param int     $collectionId
     * @param int     $id
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $collectionId, int $id)
    {
        $bookmark = $this->bookmarkRepository->findOneById($id);

        if ($bookmark->getCollection()->getId() !== $collectionId) {
            throw new NotFoundHttpException('Bookmark not found.');
        }

        $command = UpdateBookmarkCommand::createFromBookmark($bookmark);
        $form = $this->formFactory->create(UpdateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);

            return new RedirectResponse($this->router->generate('collection', [
                'collectionId' => $collectionId,
            ]));
        }

        return $this->engine->renderResponse('bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form->createView(),
        ]);
    }
}
