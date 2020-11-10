<?php

namespace App\Service;

use App\Model\WebContactMessage;
use Exception;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailNotificationsService
{
    private MailerInterface $mailer;
    private string          $adminManagerEmail;
    private string          $frontProjectTitle;

    public function __construct(MailerInterface $mailer, string $adminManagerEmail, string $frontProjectTitle)
    {
        $this->mailer = $mailer;
        $this->adminManagerEmail = $adminManagerEmail;
        $this->frontProjectTitle = $frontProjectTitle;
    }

    public function sendWebContactMessageFormSendedNotificationToAdminManager(WebContactMessage $webContactMessage): bool
    {
        $result = true;
        try {
            $email = (new TemplatedEmail())
                ->from($this->adminManagerEmail)
                ->to($this->adminManagerEmail)
                ->subject('Consulta formulario web '.$this->frontProjectTitle)
                ->htmlTemplate('email_notifications/web_contact_message_form_sended_notification_to_admin_manager.html.twig')
                ->context([
                    'importance' => NotificationEmail::IMPORTANCE_URGENT,
                    'web_contact_message' => $webContactMessage,
                ])
            ;
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $result = false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function sendWebContactMessageFormAnswerNotificationToSender(WebContactMessage $webContactMessage): bool
    {
        $result = true;
        try {
            $email = (new TemplatedEmail())
                ->from($this->adminManagerEmail)
                ->to($webContactMessage->getEmail())
                ->subject('Consulta en formulario web '.$this->frontProjectTitle.' recibida')
                ->htmlTemplate('email_notifications/web_contact_message_form_answer_notification_to_sender.html.twig')
                ->context([
                    'importance' => NotificationEmail::IMPORTANCE_HIGH,
                    'web_contact_message' => $webContactMessage,
                ])
            ;
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $result = false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }
}
