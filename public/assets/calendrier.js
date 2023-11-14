// import "/public/assets/styles/calendrier.css";

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    axios.get('/afficher/calendrier')
    .then(function (response) {
        let evenementsJSON = response.data;
        let calendarEl = document.getElementById("calendrier");

        let calendar = new Calendar(calendarEl, {
            events: evenementsJSON,
            displayEventTime: false,
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
    })
    .catch(function (error) {
        console.error('Erreur lors de la récupération des événements du calendrier', error);
    });
});