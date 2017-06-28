<?php

namespace App\Ui\Action\Security;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FormLoginAction
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * FormLoginAction constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param EngineInterface     $engine
     */
    public function __construct(AuthenticationUtils $authenticationUtils, EngineInterface $engine)
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->engine = $engine;
    }

    public function __invoke()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->engine->renderResponse('security/form-login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
