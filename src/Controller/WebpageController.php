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
           $this->addFlash('success', 'Contact form sent successfully, we\'ll answer you as soon as possible.');
      //     $dispatcher = new EventDispatcher();
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

}
