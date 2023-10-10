<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Disponibilite;
use App\Entity\Kinesitherapeute;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Je modifie pour inclure la logique de la vue de calendrier et de la liste déroulante des kinés
 */
class CalendrierController extends AbstractController
{
    #[Route('/calendrier')]
    public function index(): Response
    {
        $kines = $this->getKinesFromDatabase(); // données kinés
        $dates = $this->getDatesFromDatabase();
        $heures = $this->getDatesFromDatabase();

        return $this->render('calendrier/index.html.twig', [
            'kines' => $kines,
            'dates' => $dates,
            'heures' => $heures,
        ]);
    }

    private function getDatesFromDatabase()
    {
        // Utiliser Doctrine pour récupérer les dates depuis la bd
        $entityManager = $this->getDoctrine()->getManager();

        // entité "Date" qui représente les dates en bd
        $datesRepository = $entityManager->getRepository(RendezVous::class);

        // Récupérer les dates depuis la bd
        $dates = $datesRepository->findAll();

        return $dates;
    }

    private function getKinesFromDatabase()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $kinesRepository = $entityManager->getRepository(Kinesitherapeute::class);

        $kines = $kinesRepository->findAll();

        return $kines;
    }

    public function reservation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVous);

        // Traiter le formulaire lorsqu'il est soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $rendezVous = $form->getData();

            // enregistrer le RendezVous dans la bd
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            // Rediriger l'utilisateur vers la page du calendrier
            return $this->redirectToRoute('calendrier');
        }
        // Si le formulaire n'est pas encore soumis ou n'est pas valide ou si le traitement du formulaire a échoué, afficher le formulaire
        return $this->render('formulaire_reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
