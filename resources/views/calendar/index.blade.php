@extends('components.layouts.nav')

@section('title')
    Agenda
@endsection

@section('style')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            titleFormat: { year: 'numeric', month: '2-digit' },
            height: 300,
            locale: 'es',
            events: [
                {
                display: 'none'
                }
            ],
        });
        calendar.render();
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //     var calendarEl = document.getElementById('main-calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridWeek',
    //         locale: 'es',
    //     });
    //     calendar.render();
    // });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('main-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                center: 'dayGridMonth,dayGridWeek,timeGridOneDay' // buttons for switching between views
            },
            views: {
                timeGridOneDay: {
                type: 'timeGrid',
                duration: { days: 1 },
                buttonText: 'Día'
                },
                dayGridMonth: {
                    buttonText: 'Mes',
                },
                dayGridWeek: {
                    buttonText: 'Semana',
                }
            },
            locale: 'es',
        });
        calendar.render();
    });

</script>
@endsection

@section('main-content')
<div class="main-content-calendar">
    <div class="columns m-0 mr-3">

        {{-- Side calendar --}}
        <div class="column is-3 calendar-column">
            <div class="box calendar-box">
                <div id='calendar' class="calendar "></div>
                <hr class="centered">
            </div>
        </div>

        {{-- Main calendar --}}
        <div class="column calendar-column">
            <div class="box calendar-box">
                <div id='main-calendar' class="main-calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection
