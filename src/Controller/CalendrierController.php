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
        $patient = new Patient();
        $dispo = new Disponibilite();
        
        $rendezVous = new RendezVous();
        $rendezVous->setPatient($patient);
        $rendezVous->setDateDisponible($dispo);

        $form = $this->createForm(RendezVousType::class, $rendezVous);

        // Traiter le formulaire lorsqu'il est soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenir l'objet Patient à partir de la base de données en utilisant $patientId
            $entityManager = $this->getDoctrine()->getManager();
            $patient = $entityManager->getRepository(Patient::class)->find($patientId);

            // Création objet RendezVous et remplis avec les données du formulaire
            $rendezVous = new RendezVous();
            $rendezVous->setHeureDebut($form->get('heure')->getData());
            $rendezVous->setDateHeureDebut($form->get('date')->getData());

            // Persister l'objet RendezVous dans la bd
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            return $this->redirectToRoute('calendrier'); // Rediriger l'utilisateur vers la page du calendrier

            return $this->render('reservation/formulaire_reservation.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}
