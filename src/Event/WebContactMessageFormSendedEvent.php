<?php

namespace App\Event;

use App\Model\WebContactMessage;
use Symfony\Contracts\EventDispatcher\Event;

class WebContactMessageFormSendedEvent extends Event
{
    public const SENDED = 'web_contact_message.form_sended';

    private WebContactMessage $webContactMessage;

    public function __construct(WebContactMessage $webContactMessage)
    {
        $this->webContactMessage = $webContactMessage;
    }

    public function getWebContactMessage(): WebContactMessage
    {
        return $this->webContactMessage;
    }
}
