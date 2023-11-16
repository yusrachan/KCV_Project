<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Disponibilite;
use App\Entity\TrancheHoraire;
use App\Entity\Kinesitherapeute;
use App\Entity\TestEvenement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DependencyInjection\Security\UserProvider\EntityFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * Je modifie pour inclure la logique de la vue de calendrier et de la liste déroulante des kinés
 */
class CalendrierController extends AbstractController
{
    #[Route('/afficher/calendrier', name: 'afficher_calendrier')]
    public function index(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        //utilisation de la méthode afficherCalendrier pour obtenir les données des événements, les transformer au bon format et les sérialiser en JSON avant de les rendre dans le template Twig
        $evenements = $this->getDoctrine()->getRepository(Disponibilite::class)->findAll();
        $tranchesHoraires = $this->getDoctrine()->getRepository(TrancheHoraire::class)->findAll();

        // Associer chaque disponibilité à une tranche horaire aléatoire
        foreach ($evenements as $evenement) {
            if (!$evenement->getTrancheHoraire()) {
                // Récupérer une tranche horaire aléatoire parmi les tranches disponibles
                $trancheHoraireAleatoire = $tranchesHoraires[array_rand($tranchesHoraires)];
        
                // Assigner la tranche horaire à la disponibilité
                $evenement->setTrancheHoraire($trancheHoraireAleatoire);
        
                // Enregistrer les modifications dans la base de données
                $entityManager->persist($evenement);
            }
        }

        // Enregistrer toutes les modifications dans la base de données
        $entityManager->flush();
        
        $evenementsArray = [];

        foreach ($evenements as $evenement) {

            $trancheHoraire = $evenement->getTrancheHoraire();

            // Associer l'heure aléatoire à la date de Disponibilite
            $dateAvecHeureDebut = $evenement->getDateDisponible()->format('Y-m-d') . ' ' . $trancheHoraire->getHeureDebut()->format('H:i:s');

            // Ajouter une durée d'une heure à l'heure de début pour obtenir l'heure de fin
            $dateAvecHeureFin = (new \DateTime($dateAvecHeureDebut))->modify('+1 hour')->format('Y-m-d H:i:s');

            $evenementsArray[] = [
                'id' => $evenement->getId(),
                'title' => $evenement->getKineDispo()->getNomComplet(),
                'start' => $dateAvecHeureDebut,
                'end' => $dateAvecHeureFin,
                'backgroundColor' => $evenement->getBackgroundColor(),
                'textColor' => $evenement->getTextColor(),
                'borderColor' => $evenement->getBorderColor(),
            ];
        }

        $evenementsJSON = $serializer->serialize($evenementsArray, 'json');

        return $this->render('calendrier/afficher_calendrier.html.twig', [
            'evenementsJSON' => $evenementsJSON,
        ]);
    }

    #[Route('/ajouter/patient', name: 'ajouter_patient', methods: ['POST'])]
    public function ajouterPatient(Request $request): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Créer une nouvelle instance de l'entité Patient
        $nouveauPatient = new Patient();
        $nouveauPatient->setPrenom($data['prenom']);
        $nouveauPatient->setNom($data['nom']);

        $telephone = (int) $data['numero'];
        $nouveauPatient->setTelephone($telephone);
        $nouveauPatient->setEmail($data['email']);
        $nouveauPatient->setAdresse($data['adresse']);

        // Persistez l'entité dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nouveauPatient);
        $entityManager->flush();

        // Retourner une réponse JSON avec l'ID du patient nouvellement créé
        return $this->json(['id' => $nouveauPatient->getId()]);
    }

    #[Route('/ajouter/rendezvous', name: 'ajouter_rendezvous', methods: ['POST'])]
    public function ajouterRendezVous(Request $request): Response
    {
        // Récupérer les données du formulaire
        $data = json_decode($request->getContent(), true);

        // Récupérer le kinesitherapeute et le patient en fonction de leurs IDs
        $kinesitherapeute = $this->getDoctrine()->getRepository(Kinesitherapeute::class)->find($data['kinesitherapeuteId']);
        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($data['patientId']);

        // Créer une nouvelle instance de l'entité RendezVous
        $rendezVous = new RendezVous();
        $rendezVous->setKinesitherapeute($kinesitherapeute);
        $rendezVous->setPatient($patient);
        // Assurez-vous que les champs heureDebutId et dateHeureDebut sont définis dans votre modèle RendezVous
        $rendezVous->setHeureDebut($data['heureDebutId']);
        $rendezVous->setDateHeureDebut(new \DateTime($data['dateHeureDebut']));

        // Enregistrer le rendez-vous dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rendezVous);
        $entityManager->flush();

        // Retourner une réponse JSON si nécessaire
        return $this->json(['success' => true]);
    }
}
