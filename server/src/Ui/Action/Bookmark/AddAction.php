<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\CreateBookmarkCommand;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Ui\Form\Type\Bookmark\CreateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * AddAction constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CommandBus                    $commandBus
     * @param FormFactoryInterface          $formFactory
     * @param EngineInterface               $engine
     * @param RouterInterface               $router
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router
    ) {
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @param Request $request
     * @param int     $collectionId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $collectionId)
    {
        $collection = $this->collectionRepository->findOneById($collectionId);
        $command = new CreateBookmarkCommand(null, null, $collection->getId());
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);

            return new RedirectResponse($this->router->generate('collection', [
                'collectionId' => $collection->getId(),
            ]));
        }

        return $this->engine->renderResponse('bookmark/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
