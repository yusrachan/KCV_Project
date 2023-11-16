// import "/public/assets/styles/calendrier.css";

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    initializeCalendar();

    // Afficher la fenêtre modale
    document.getElementById("calendrier").addEventListener("click", function () {
        document.getElementById("modal").style.display = "block";
    });

    // Masquer la fenêtre modale en cliquant à l'extérieur
    window.addEventListener("click", function (event) {
        if (event.target === document.getElementById("modal")) {
            document.getElementById("modal").style.display = "none";
        }
    });

    let modal = document.querySelector('.modal');
    let calendar = document.getElementById('calendrier');

    calendar.addEventListener('eventClick', function (info) {
        // Ajustez le z-index de la modal pour qu'elle soit en premier plan
        modal.style.zIndex = 1000; // Valeur plus élevée
    });
});

// function validerFormulaire() {
//     let prenom = document.getElementById('prenom').value;
//     let nom = document.getElementById('nom').value;
//     let numero = document.getElementById('numero').value;
//     let email = document.getElementById('email').value;
//     let adresse = document.getElementById('adresse').value;

//     // Envoyer les données au serveur (vous pouvez utiliser Axios ou une autre méthode)

//     // Ajouter les données à la table Patient (exemple avec Axios)
//     axios.post('/ajouter/patient', {
//         prenom: prenom,
//         nom: nom,
//         numero: numero,
//         email: email,
//         adresse: adresse
//     })
//     .then(function (response) {
//         // Une fois les données ajoutées à la table Patient, obtenir l'ID du patient
//         let patientId = response.data.id;

//         // Ajouter les données à la table RendezVous
//         // Assurez-vous d'avoir une route appropriée et un contrôleur pour gérer cela côté serveur
//         axios.post('/ajouter/rendezvous', {
//             kinesitherapeuteId: kinesitherapeuteId,
//             patientId: patientId,
//             heureDebutId: heureDebutId, 
//             dateHeureDebut: dateHeureDebut 
//         })
//         .then(function (response) {
//             // Une fois les données ajoutées à la table RendezVous, fermer le modal
//             $('#modal').modal('hide');

//             // Mettre à jour le calendrier pour supprimer l'événement
//             calendar.refetchEvents();
//         })
//         .catch(function (error) {
//             console.error('Erreur lors de l\'ajout du rendez-vous', error);
//         });
//     })
//     .catch(function (error) {
//         console.error('Erreur lors de l\'ajout du patient', error);
//     });
// }

function initializeCalendar() {
    const calendarEl = document.getElementById("calendrier");
    if (!calendarEl) {
        console.error("Element with id 'calendrier' not found.");
        return;
    }

    const evenementsJSONJS = calendarEl.dataset.calendrier;
    if (!evenementsJSONJS) {
        console.error("No calendrier data found in the dataset.");
        return;
    }

    try {
        const evenementsJSONJSArray = JSON.parse(evenementsJSONJS);
        createCalendar(calendarEl, evenementsJSONJSArray);
    } catch (error) {
        console.error("Error parsing JSON data:", error);
    }
}


function createCalendar(calendarEl, events) {
    const calendar = new Calendar(calendarEl, {
        events: events,
        initialView: "dayGridMonth",
        initialDate: new Date(),
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        plugins: [interactionPlugin, dayGridPlugin],

    });

    calendar.render();
}