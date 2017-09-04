<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\Collection\CreateCollectionCommand;
use App\Infrastructure\Helper\RoutingTrait;
use App\Ui\Form\Type\Collection\CreateType;
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
    use RoutingTrait;

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
     * @param CommandBus           $commandBus
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface      $engine
     * @param RouterInterface      $router
     * @param FlashBagInterface    $flashBag
     */
    public function __construct(
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
        $this->flashBag = $flashBag;
    }

    /**
     * @param Request $request
     * @param int     $boardId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $boardId)
    {
        $command = new CreateCollectionCommand($boardId);
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'Votre collection a été ajouté.');

            return $this->redirectToRoute('board', ['boardId' => $boardId]);
        }

        return $this->engine->renderResponse('collection/add.html.twig', [
            'boardId' => $boardId,
            'form' => $form->createView(),
        ]);
    }
}
