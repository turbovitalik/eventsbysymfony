<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/events")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();


        $now = new \DateTime('now');

        $futureEvents = $em->getRepository(Event::class)->findEventsStartAfter($now);
        $pastEvents = $em->getRepository(Event::class)->findEventsStartBefore($now);

        return $this->render('events/eventOverview.html.twig', [
            'futureEvents' => $futureEvents,
            'pastEvents' => $pastEvents,
        ]);
    }

    /**
     * @Route("/events/new")
     */
    public function new(Request $request)
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);

            $em->flush();

            return new Response('Event has been saved');
        }

        return $this->render('events/eventForm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}