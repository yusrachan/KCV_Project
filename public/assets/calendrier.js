// Importez le fichier CSS du calendrier

// Le reste de votre code JavaScript
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    // Obtenir le conteneur du calendrier
    var calendarEl = document.getElementById("calendrier");

    // Initialiser le calendrier
    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin], // Utiliser le plugin dayGrid
        initialView: "dayGridMonth", // Afficher le calendrier en vue mensuelle par défaut
    });

    // Afficher le calendrier
    calendar.render();
});
