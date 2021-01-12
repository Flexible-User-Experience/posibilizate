<?php

namespace App\Controller;

use App\Event\WebContactMessageFormSendedEvent;
use App\EventListener\EmailNotificationsListener;
use App\Form\Type\WebContactMessageType;
use App\Model\WebContactMessage;
use App\Service\EmailNotificationsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebpageController extends AbstractController
{
    /**
     * @Route("/", name="app_front_homepage")
     *
     * @param Request $request
     * @param EmailNotificationsService $ens
     *
     * @return Response
     */
  public function homepageAction(Request $request, EmailNotificationsService $ens): Response
  {
       $webContactMessage = new WebContactMessage();
       $form = $this->createForm(WebContactMessageType::class, $webContactMessage);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $this->addFlash('success', 'Formulario de consulta enviado con éxito, te responderemos lo antes posible.');
           $dispatcher = new EventDispatcher();
           $dispatcher->addSubscriber(new EmailNotificationsListener($ens));
           $event = new WebContactMessageFormSendedEvent($webContactMessage);
           $dispatcher->dispatch($event, WebContactMessageFormSendedEvent::SENDED);
           $webContactMessage = new WebContactMessage();
           $form = $this->createForm(WebContactMessageType::class, $webContactMessage);
       }

      return $this->render(
          'webpage/homepage.html.twig',
          [
               'form' => $form->createView(),
          ]
      );
  }

  /**
   * @Route("/politica-de-privacidad", name="app_front_privacy_policy")
   */
  public function privacyPolicyAction(): Response
  {
      return $this->render('webpage/privacy_policy.html.twig');
  }

  /**
   * @Route("/politica-de-cookies", name="app_front_cookies_policy")
   */
  public function cookiesPolicyAction(): Response
  {
      return $this->render('webpage/cookies_policy.html.twig');
  }
}
