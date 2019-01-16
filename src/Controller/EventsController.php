<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventPhoto;
use App\Entity\User;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/events", name="events_main")
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

        $users = $em->getRepository(User::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Event $event */
            $event = $form->getData();

            /** @var EventPhoto $photo */
            foreach ($event->getPhotos() as $photo) {
                $photo->upload();
            }

            $em->persist($event);

            $em->flush();

            return $this->redirectToRoute('events_main');
        }

        return $this->render('events/eventForm.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }

    /**
     * @Route("/events/delete/{id}", name="delete_event")
     */
    public function delete(Event $event)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($event);
        $em->flush();

        return $this->redirect('/events');
    }

    /**
     * @Route("/events/edit/{id}", name="edit_event")
     */
    public function edit(Event $event, Request $request)
    {
        $form = $this->createForm(EventType::class, $event, [
            'action' => $this->generateUrl('edit_event', ['id' => $event->getId()]),
        ]);

        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $em->persist($event);

            $em->flush();

            return $this->redirectToRoute('events_main');
        }

        return $this->render('events/eventForm.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
}