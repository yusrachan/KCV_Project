import "./assets/styles/calendrier.css";

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

document.addEventListener("DOMContentLoaded", function () {
    let dispoJSONJS = document.getElementById('calendrier').dataset.calendrier;
    let disposJSONJSArray = JSON.parse(disposJSONJS);

    let calendarEl = document.getElementById("calendrier");

    var calendar = new Calendar(calendarEl, {
        dispo: disposJSONJSArray,

        displayDispoTime: true, // cacher l'heure
        initialView: "dayGridMonth",
        initialDate: new Date(), // aujourd'hui
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },

        dateClick: function (dispo) {
            afficherFormulaire(dispo)
        }
    })
});