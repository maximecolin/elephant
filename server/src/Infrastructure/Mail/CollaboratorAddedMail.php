<?php

namespace App\Infrastructure\Mail;

use App\Domain\Mail\CollaboratorAddedMailInterface;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;

class CollaboratorAddedMail extends AbstractMailer implements CollaboratorAddedMailInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(Collaborator $collaborator, User $addedBy)
    {
        $message = new \Swift_Message();
        $message->setSender('notifications@elephant.maximecolin.fr', 'Notification Elephant');
        $message->setTo($collaborator->getUser()->getEmail());
        $message->setSubject('Vous avez été ajouté aux collaborateurs');
        $message->setBody($this->engine->render('mail/collaborator-added.html.twig', [
            'collaborator' => $collaborator,
            'addedBy' => $addedBy
        ]), 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }
}
