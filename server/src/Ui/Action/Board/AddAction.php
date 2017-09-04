<?php

namespace App\Ui\Action\Board;

use App\Application\Command\Board\CreateBoardCommand;
use App\Infrastructure\Helper\RoutingTrait;
use App\Infrastructure\Security\User\SymfonyUser;
use App\Ui\Form\Type\Board\CreateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param Request       $request
     * @param UserInterface $user
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, UserInterface $user)
    {
        if (!$user instanceof SymfonyUser) {
            throw new AccessDeniedException();
        }

        $command = new CreateBoardCommand($user->getModel());
        $form = $this->formFactory->create(CreateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'Votre board a été ajouté.');

            $this->redirectToRoute('home');
        }

        return $this->engine->renderResponse('board/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
