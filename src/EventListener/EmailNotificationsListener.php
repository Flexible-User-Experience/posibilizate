<?php

namespace App\EventListener;

use App\Event\WebContactMessageFormSendedEvent;
use App\Service\EmailNotificationsService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmailNotificationsListener implements EventSubscriberInterface
{
    private EmailNotificationsService $ens;

    public function __construct(EmailNotificationsService $ens)
    {
        $this->ens = $ens;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            WebContactMessageFormSendedEvent::SENDED => 'onWebContactMessageFormSend',
        ];
    }

    public function onWebContactMessageFormSend(WebContactMessageFormSendedEvent $event): void
    {
        $this->ens->sendWebContactMessageFormSendedNotificationToAdminManager($event->getWebContactMessage());
        $this->ens->sendWebContactMessageFormAnswerNotificationToSender($event->getWebContactMessage());
    }
}
