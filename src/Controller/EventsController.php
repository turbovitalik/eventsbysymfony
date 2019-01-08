<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventTrainer;
use App\Entity\User;
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
     * @Route("/events/single/{id}")
     */
    public function show(Event $event)
    {
        $trainers = $event->getTrainers();

        foreach ($trainers as $trainer) {
            var_dump($trainer);
        }

        die;
    }

    /**
     * @Route("/events/new")
     */
    public function new(Request $request)
    {
        $event = new Event();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EventType::class, $event);

        $trainers = $em->getRepository(User::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $em->persist($event);

            $em->flush();



//            $trainers = $event->getTrainers();





            return new Response('Event has been saved');
        }

        return $this->render('events/eventForm.html.twig', [
            'form' => $form->createView(),
            'trainers' => $trainers,
        ]);
    }
}