// see full documentation at https://fullcalendar.io/docs

import {Calendar} from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calander() {
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;
        let calendar = new Calendar(calendarEl, {
            plugins: [timeGridPlugin,dayGridPlugin,interactionPlugin],
            initialView: 'timeGridWeek',
            slotMinTime: '1:00:00',
            slotMaxTime: '24:00:00',
            eventSources: window.eventSources,
            allDaySlot: false,
            firstDay: 1,
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            headerToolbar: {
                left: 'title',
                center: 'dayGridMonth,timeGridWeek,timeGridDay',
                right: 'prev,next'
            },
            dateClick: function(info) {
                $("#add-resource-modal").addClass('flex').removeClass('hidden');
                $('#curtain').addClass('block').removeClass('hidden');
                let currentDate = info.dateStr.substring(0,10);
                let currentTime = info.dateStr.substring(11,16);

                $("#add-resource-modal form input[name='date']").val(currentDate);
                $("#add-resource-modal form input[name='start_time']").val(currentTime);

                $('.meeting-modal-input-grid').val(calendar.view.type);
            },
            eventClick: function(info) {
                // get view type and date
                let view = calendar.view.type;
                let date = info.view.currentStart;
                date.setDate(date.getDate() + 1);
                date = date.toISOString().split('T')[0];

                // open meeting edit
                let id = info.event._def.publicId;
                let url = '/meetings/edit/' + id + '?grid=' + view + '&date=' + date;
                window.location.href = url;
            }
        });

        // get value from url parameter and adjust calendar view
        let url = new URL(window.location.href);
        let grid = url.searchParams.get("grid");
        let date = url.searchParams.get("date");
        if (grid && date) {
            calendar.changeView(grid, date);
        }
        
        calendar.render();
    });
}
