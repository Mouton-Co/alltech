// see full documentation at https://fullcalendar.io/docs

import { Calendar } from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calander() {
    document.addEventListener("DOMContentLoaded", function () {
        let calendarEl = document.getElementById("calendar");
        if (!calendarEl) return;
        let calendar = new Calendar(calendarEl, {
            plugins: [timeGridPlugin, dayGridPlugin, interactionPlugin],
            initialView: "timeGridWeek",
            slotMinTime: "1:00:00",
            slotMaxTime: "24:00:00",
            eventSources: window.eventSources,
            allDaySlot: true,
            allDayText: "All Day",
            firstDay: 1,
            slotLabelFormat: {
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
            },
            headerToolbar: {
                left: "title",
                center: "dayGridMonth,timeGridWeek,timeGridDay",
                right: "prev,next",
            },
            dateClick: function (info) {
                $("#add-resource-modal").addClass("flex").removeClass("hidden");
                $("#curtain").addClass("block").removeClass("hidden");
                let currentDate = info.dateStr.substring(0, 10);
                let currentTime = info.dateStr.substring(11, 16);

                // get view type and date
                let view = calendar.view.type;
                let date = info.view.currentStart;
                date.setDate(date.getDate() + 1);
                date = date.toISOString().split("T")[0];

                $("#add-resource-modal form input[name='date']").val(
                    currentDate
                );
                $("#add-resource-modal form input[name='end_date']").val(
                    currentDate
                );
                $("#add-resource-modal form input[name='start_time']").val(
                    currentTime
                );

                // set view type and date
                $(".meeting-modal-input-grid").val(view);
                $(".meeting-modal-input-start_date").val(date);

                $(".meeting-modal-input-grid").val(calendar.view.type);
            },
            eventClick: function (info) {
                // get view type and date
                let view = calendar.view.type;
                let date = info.view.currentStart;
                date.setDate(date.getDate() + 1);
                date = date.toISOString().split("T")[0];

                // get users from url parameter
                let usersParam = "";
                for (
                    let i = 1;
                    i < window.location.search.split("users").length;
                    i++
                ) {
                    usersParam +=
                        "&users[]=" +
                        window.location.search
                            .split("users")
                            [i].split("=")[1]
                            .split("&")[0];
                }

                // get display from url parameter
                let display = "";
                if (window.location.search.includes("display")) {
                    display =
                        "&display=" +
                        window.location.search
                            .split("display")[1]
                            .split("=")[1]
                            .split("&")[0];
                }

                // open meeting edit
                let id = info.event._def.publicId;
                let url =
                    "/meetings/edit/" +
                    id +
                    "?grid=" +
                    view +
                    "&start_date=" +
                    date +
                    "&" +
                    usersParam +
                    display;
                window.location.href = url;
            },
        });

        // get value from url parameter and adjust calendar view
        let url = new URL(window.location.href);
        let grid = url.searchParams.get("grid");
        let date = url.searchParams.get("start_date");
        if (grid && date) {
            calendar.changeView(grid, date);
        }

        calendar.render();
    });
}
