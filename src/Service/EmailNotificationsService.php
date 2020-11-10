<?php

namespace App\Service;

use App\Model\WebContactMessage;
use Exception;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
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

    public function sendWebContactMessageFormSendedNotificationToAdminManager(WebContactMessage $webContactMessage)
    {
        $result = true;
        try {
            $email = (new TemplatedEmail())
                ->from($this->adminManagerEmail)
                ->to($this->adminManagerEmail)
                ->subject('Web contact message #'.$webContactMessage->getId().' form sended')
                ->htmlTemplate('email_notifications/web_contact_message_form_sended_notification_to_admin_manager.html.twig')
                ->context([
                    'importance' => NotificationEmail::IMPORTANCE_MEDIUM,
                    'web_contact_message' => $webContactMessage,
                ])
            ;
            $this->mailer->send($email);
        } catch (TransportException $e) {
            $result = false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function sendWebContactMessageFormAnswerNotificationToSender(WebContactMessage $webContactMessage)
    {
        $result = true;
        try {
            $email = (new TemplatedEmail())
                ->from($this->adminManagerEmail)
                ->to($webContactMessage->getEmail())
                ->subject($this->frontProjectTitle.' web contact message answer')
                ->htmlTemplate('email_notifications/web_contact_message_form_answer_notification_to_sender.html.twig')
                ->context([
                    'importance' => NotificationEmail::IMPORTANCE_LOW,
                    'web_contact_message' => $webContactMessage,
                ])
            ;
            $this->mailer->send($email);
        } catch (TransportException $e) {
            $result = false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }
}
