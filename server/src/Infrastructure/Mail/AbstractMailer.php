<?php

namespace App\Infrastructure\Mail;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

abstract class AbstractMailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer   $mailer
     * @param EngineInterface $engine
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $engine)
    {
        $this->mailer = $mailer;
        $this->engine = $engine;
    }
}
