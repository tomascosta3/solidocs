@extends('components.layouts.nav')

@section('title')
    Agenda
@endsection

@section('style')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>

    function openModal(date) {
        const modal = document.getElementById('eventModal');
        modal.classList.add('is-active');
        document.getElementById('selectedDate').innerText = date;
        document.getElementById('dateInput').value = date;
    }

    function closeModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.remove('is-active');
    }

    // Side calendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            titleFormat: { year: 'numeric', month: 'short' },
            height: 300,
            locale: 'es',
            events: [
                {
                display: 'none'
                }
            ],
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next today'
            },
            buttonText: {
                today: 'hoy'
            }
        });
        calendar.render();
    });

    // Main calendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('main-calendar');
        var events = @json($calendar->events); // Convert events in json format.
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
            buttonText: {
                today: 'hoy'
            },
            dateClick: function(info) {
                openModal(info.dateStr);
                if(document.getElementById('all_day').checked) {
                    document.querySelector('input[name="start_date"]').value = info.dateStr + "T00:00";
                    document.querySelector('input[name="end_date"]').value = info.dateStr + "T23:59";
                }
            },
            events: events,
        });
        calendar.render();
    });

</script>
@endsection

@section('main-content')

{{-- Add event modal --}}
<div class="modal" id="eventModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Crear evento para: <span id="selectedDate"></span></p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="eventForm" action="{{ route('calendars.events.store', ['calendar' => $calendar->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="date" id="dateInput">

                <div class="field">
                    <label class="label" for="event_type_id">Tipo de Evento:</label>
                    <div class="control">
                        <div class="select">
                            <select name="event_type_id" required>
                                @foreach($event_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="title">Título:</label>
                    <div class="control">
                        <input class="input" type="text" name="title" required>
                    </div>
                </div>

                <div class="field">
                    <label class="checkbox" for="all_day">
                        <input type="checkbox" name="all_day" id="all_day">
                        Todo el día
                    </label>
                </div>

                <div class="field">
                    <label class="label" for="start_date">Fecha Inicio:</label>
                    <div class="control">
                        <input class="input" type="datetime-local" name="start_date" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="end_date">Fecha Fin:</label>
                    <div class="control">
                        <input class="input" type="datetime-local" name="end_date" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="location">Ubicación:</label>
                    <div class="control">
                        <input class="input" type="text" name="location">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="comment">Comentario:</label>
                    <div class="control">
                        <textarea class="textarea" name="comment"></textarea>
                    </div>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" type="submit" form="eventForm">Guardar</button>
            <button class="button" type="button" onclick="closeModal()">Cancelar</button>
        </footer>
    </div>
</div>


<div id="eventModal" style="display:none;">
    <h3>Crear Evento para: <span id="selectedDate"></span></h3>

    <form id="eventForm" action="{{ route('calendars.events.store', ['calendar' => $calendar->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="date" id="dateInput"> <!-- Para almacenar la fecha seleccionada -->

        <div>
            <label for="event_type_id">Tipo de Evento:</label>
            <select name="event_type_id" required>
                {{-- @foreach($eventTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach --}}
                <option value="">tipo 1</option>
                <option value="">tipo 2</option>
                <option value="">tipo 3</option>
            </select>
        </div>

        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" required>
        </div>

        <div>
            <label for="all_day">Todo el día:</label>
            <input type="checkbox" name="all_day" id="all_day">
        </div>

        <div>
            <label for="start_date">Fecha Inicio:</label>
            <input type="datetime-local" name="start_date" required>
        </div>

        <div>
            <label for="end_date">Fecha Fin:</label>
            <input type="datetime-local" name="end_date" required>
        </div>

        <div>
            <label for="location">Ubicación:</label>
            <input type="text" name="location">
        </div>

        <div>
            <label for="comment">Comentario:</label>
            <textarea name="comment"></textarea>
        </div>

        <div>
            <button type="submit">Guardar</button>
            <button type="button" onclick="closeModal()">Cancelar</button>
        </div>
    </form>
</div>

<div class="main-content-calendar">
    <div class="columns m-0 mr-3">

        {{-- Side calendar --}}
        <div class="column is-3 calendar-column">
            <div class="box calendar-box">
                <div id='calendar' class="calendar"></div>
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
