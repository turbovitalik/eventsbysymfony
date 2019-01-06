<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    /**
     * @Route("/index")
     */
    public function index()
    {
        return $this->render('events/eventForm.html.twig', []);
    }
}