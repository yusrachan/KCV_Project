<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Je modifie pour inclure la logique de la vue de calendrier et de la liste déroulante des kinés
 */
class CalendrierController extends AbstractController
{
    #[Route('/calendrier')]
    public function index(): Response
    {
        $kines = ['Arigui Yassine', 'Truc Julie', 'El Machin Ayyoub']; // données kinés

        return $this->render('calendrier/index.html.twig', [
            'kines' => $kines,
            'dates' => $dates,
        ]);
    }
}
