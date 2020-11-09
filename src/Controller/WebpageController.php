<?php

namespace App\Controller;

use App\Form\Type\WebContactMessageType;
use App\Model\WebContactMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WebpageController extends AbstractController
{
  /**
   * @Route("/", name="app_front_homepage")
   */
  public function homepageAction(Request $request)
  {
       $webContactMessage = new WebContactMessage();
       $form = $this->createForm(WebContactMessageType::class, $webContactMessage);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $this->addFlash('success', 'Formulario de consulta enviado con éxito, te responderemos lo antes posible.');
      //     TODO $dispatcher = new EventDispatcher();
      //     $dispatcher->addSubscriber(new EmailNotificationsListener($ens));
      //     $event = new WebContactMessageFormSendedEvent($webContactMessage);
      //     $dispatcher->dispatch($event, WebContactMessageFormSendedEvent::SENDED);
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
  public function privacyPolicyAction()
  {
      return $this->render('webpage/privacy_policy.html.twig');
  }

  /**
   * @Route("/condiciones-legales", name="app_front_terms_and_conditions")
   */
  public function termsAndConditionsAction()
  {
      return $this->render('webpage/terms_and_conditions.html.twig');
  }
}
