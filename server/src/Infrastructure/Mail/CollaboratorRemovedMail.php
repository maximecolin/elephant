<?php

namespace App\Infrastructure\Mail;

use App\Domain\Mail\CollaboratorRemovedMailInterface;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;

class CollaboratorRemovedMail extends AbstractMailer implements CollaboratorRemovedMailInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(Collaborator $collaborator, User $removedBy)
    {
        $message = new \Swift_Message();
        $message->setSender('notifications@elephant.maximecolin.fr', 'Notification Elephant');
        $message->setTo($collaborator->getUser()->getEmail());
        $message->setSubject('Vous avez été retirer des collaborateurs');
        $message->setBody($this->engine->render('mail/collaborator-removed.html.twig', [
            'collaborator' => $collaborator,
            'removedBy' => $removedBy
        ]), 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }
}
