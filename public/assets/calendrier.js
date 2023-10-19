import "./assets/styles/calendrier.css";

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

document.addEventListener("DOMContentLoaded", function () {

    let div_calendrier = document.getElementById("div_calendrier");
    let dispoJSONJS = div_calendrier.dataset.calendrier;

    let disposArray = JSON.parse(dispoJSONJS);

    let calendar = new Calendar(div_calendrier, {
        events: disposArray,

        initialView: "dayGridMonth",
        initialDate: new Date(), // aujourd'hui
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },

        dateClick: function (info) {
            console.log(info.dateStr);
            //implémenter la fonction afficherFormulaire pour gérer l'affichage du formulaire.
            afficherFormulaire(dispo)
        }
    });
    //appeler render() pour afficher le calendrier.
    calendar.render();
});