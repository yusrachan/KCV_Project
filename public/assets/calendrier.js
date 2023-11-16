// import "/public/assets/styles/calendrier.css";

import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";

import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    initializeCalendar();
});

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