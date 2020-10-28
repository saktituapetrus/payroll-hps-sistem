"use strict";


$("#myEvent").fullCalendar({

    height: 'auto',
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    editable: true,
    // events: [
    //   {
    //     title: 'Kite Day',
    //     start: '2020-01-14',
    //     backgroundColor: "green",
    //     borderColor: "#fff",
    //     textColor: '#000'
    //   },
    // ]

    events: arrEvents,

});

$(document).on('click', '.fc-day-grid-event', function (e) {
    // if (!$(this).hasClass('project')) {
    e.preventDefault();
    var event = $(this);
    var title = $(this).find('.fc-content .fc-title').html();
    var size = 'md';
    var url = $(this).attr('href');
    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            $('#commonModal .modal-body').html(data);
            $("#commonModal").modal('show');
            common_bind();
        },
        error: function (data) {
            data = data.responseJSON;
            show_msg('Error', data.error, 'error');
        }
    });
    // }
});

function common_bind() {
    if ($(".datepicker").length) {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            format: 'yyyy-mm-dd',
            locale: {format: 'YYYY-MM-DD'},
            // todayHighlight: true,
        });
    }
}

