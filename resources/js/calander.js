import {Calendar} from "@fullcalendar/core";
import timeGridPlugin from "@fullcalendar/timegrid";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export function calander() {
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            plugins: [timeGridPlugin,dayGridPlugin,interactionPlugin],
            initialView: 'timeGridWeek',
            slotMinTime: '6:00:00',
            slotMaxTime: '20:00:00',
            events: window.events,
            allDaySlot: false,
            firstDay: 1,
            headerToolbar: {
                left: 'title',
                center: 'dayGridMonth,timeGridWeek,timeGridDay',
                right: 'prev,next'
            },
            dateClick: function(info) {
                $("#add-resource-modal").addClass('flex').removeClass('hidden');
                $('#curtain').addClass('block').removeClass('hidden');
                console.log(info.dateStr)
                let currentDate = info.dateStr.substring(0,10);
                let currentTime = info.dateStr.substring(11,16);

                $("#add-resource-modal form input[name='date']").val(currentDate);
                $("#add-resource-modal form input[name='start_time']").val(currentTime);
            },
            eventClick: function(info) {
                let id = info.event._def.publicId;
                $("#edit-resource-modal-" + id).addClass('flex').removeClass('hidden');
                $('#curtain').addClass('block').removeClass('hidden');
            }
        });
        calendar.render();
    });
}
