<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\CreateCollectionCommand;
use App\Ui\Form\Type\Collection\CreateType;
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
     * @param CommandBus           $commandBus
     * @param FormFactoryInterface $formFactory
     * @param EngineInterface      $engine
     * @param RouterInterface      $router
     */
    public function __construct(
        CommandBus $commandBus,
        FormFactoryInterface $formFactory,
        EngineInterface $engine,
        RouterInterface $router
    ) {
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->engine = $engine;
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request)
    {
        $command = new CreateCollectionCommand();
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);

            return new RedirectResponse($this->router->generate('home'));
        }

        return $this->engine->renderResponse('collection/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
