<?php

namespace App\Ui\Action;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class HomeAction
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * HomeAction constructor.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function __invoke()
    {
        return $this->engine->renderResponse('home.html.twig');
    }
}
