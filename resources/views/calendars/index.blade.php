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
        document.getElementById('eventForm').reset();
    }

    function openNewCalendarModal() {
        const modal = document.getElementById('new-calendar');
        modal.classList.add('is-active');
    }

    function closeNewCalendarModal() {
        const modal = document.getElementById('new-calendar');
        modal.classList.remove('is-active');
        document.getElementById('new-calendar-form').reset();
    }

    /**
     * When 'all day' checkbox is selected, puts start and end date on 
     * inputs.
     */
    function toggleAllDay() {
        var startDateInput = document.querySelector('input[name="start_date"]');
        var endDateInput = document.querySelector('input[name="end_date"]');

        if (document.getElementById('all_day').checked) {

            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);

            startDate.setHours(0, 0, 0);  // Set to 12:00 AM
            endDate.setHours(23, 59, 59); // Set to 11:59 PM

            startDateInput.value = formatDate(startDate);
            endDateInput.value = formatDate(endDate);
        }
    }

    function formatDate(date) {

        var year = date.getFullYear(),
            month = ('0' + (date.getMonth() + 1)).slice(-2),
            day = ('0' + date.getDate()).slice(-2),
            hour = ('0' + date.getHours()).slice(-2),
            minute = ('0' + date.getMinutes()).slice(-2);

        return year + '-' + month + '-' + day + 'T' + hour + ':' + minute;
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

    @if ($calendar)
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
                    document.querySelector('input[name="start_date"]').value = info.dateStr + "T00:00";
                    document.querySelector('input[name="end_date"]').value = info.dateStr + "T23:59";

                    openModal(info.dateStr);
                },
                events: events,
            });
            calendar.render();
        });
    @endif

    document.addEventListener('DOMContentLoaded', function() {
        let selectedUsers = [];
        
        document.querySelectorAll('.toggle-user').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.dataset.userId;
                if (selectedUsers.includes(userId)) {
                    selectedUsers = selectedUsers.filter(id => id !== userId);
                    this.classList.remove('is-primary');
                } else {
                    selectedUsers.push(userId);
                    this.classList.add('is-primary');
                }
                document.getElementById('selectedUsers').value = selectedUsers.join(',');
            });
        });
    });

</script>
@endsection

@section('main-content')

@if ($calendar)  
{{-- Add event modal --}}
<div class="modal" id="eventModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Crear evento para: <span id="selectedDate"></span></p>
            <button class="delete" aria-label="close" onclick="closeModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="eventForm" action="{{ route('calendars.events.store', ['calendar' => $calendar->id]) }}" method="post">
                @csrf
                <input type="hidden" name="date" id="dateInput">

                <div class="columns is-vcentered is-mobile">
                    <div class="column is-narrow">
                        <label class="label" for="event_type_id">Tipo de Evento:</label>
                    </div>
                    <div class="column">
                        <div class="field">
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
                    </div>
                </div>
                
                
                <div class="field">
                    <div class="control">
                        <input class="input" type="text" name="title" placeholder="Ingrese el título..." required>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label" for="start_date">Fecha Inicio:</label>
                            <div class="control">
                                <input class="input" type="datetime-local" name="start_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label" for="end_date">Fecha Fin:</label>
                            <div class="control">
                                <input class="input" type="datetime-local" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="field">
                    <label class="checkbox" for="all_day">
                        <input type="checkbox" name="all_day" id="all_day" onchange="toggleAllDay()">
                        Todo el día
                    </label>
                </div>

                <div class="columns is-vcentered is-mobile">
                    <div class="column is-narrow">
                        <label class="label" for="reminder">Recordatorio:</label>
                    </div>
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select name="reminder">
                                        <option value="none">Ninguno</option>
                                        <option value="5">5 minutos antes</option>
                                        <option value="10">10 minutos antes</option>
                                        <option value="15">15 minutos antes</option>
                                        <option value="30">30 minutos antes</option>
                                        <option value="60">1 hora antes</option>
                                        <option value="120">2 horas antes</option>
                                        <option value="1440">1 día antes</option>
                                        <option value="2880">2 días antes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
@endif

{{-- Create calendar modal --}}
<div class="modal" id="new-calendar">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Crear nuevo calendario</p>
            <button class="delete" aria-label="close" onclick="closeNewCalendarModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="new-calendar-form" action="{{ route('calendars.create') }}" method="post">
                @csrf
                <div class="field">
                    <label class="label" for="name">Nombre del calendario:</label>
                    <div class="control">
                        <input class="input" type="text" name="name" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="users">Seleccionar Usuarios:</label>
                    <div class="control">
                        <div class="select is-multiple">
                            <select name="users[]" multiple size="5">
                                @foreach($users_in_organization as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @foreach($users_in_organization as $user)
                    <button class="button is-light toggle-user" data-user-id="{{ $user->id }}" type="button">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </button>
                @endforeach
                <input type="hidden" name="users" id="selectedUsers">
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" type="submit" form="new-calendar-form">Guardar</button>
            <button class="button" type="button" onclick="closeNewCalendarModal()">Cancelar</button>
        </footer>
    </div>
</div>

<div class="main-content-calendar">
    <div class="columns m-0 mr-3">

        {{-- Side calendar --}}
        <div class="column is-3 calendar-column">
            <div class="box calendar-box">
                <div id='calendar' class="calendar"></div>
                <hr class="centered">

                {{-- Calendars list --}}
                <div class="calendar-list pb-2">
                    @foreach ($calendars as $calendar)
                    <a href="{{ route('calendars.show', ['calendar_id' => $calendar->id]) }}">
                        <div class="box p-2 is-shadowless has-text-centered {{ !$loop->last ? 'mb-2' : '' }}">
                            {{ $calendar->name }}
                        </div>
                    </a>
                    @endforeach
                </div>

                <a href="#" onclick="openNewCalendarModal()">
                    <div class="box p-2 is-shadowless has-text-centered mt-4">
                        <div class="has-text-centered is-flex is-align-items-center is-justify-content-center">
                            <i class="bx bx-plus nav-icon create-icon"></i>
                            <span class="pl-3">Crear nuevo calendario</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @if ($calendar)
        {{-- Main calendar --}}
        <div class="column calendar-column">
            <div class="box calendar-box">
                <div id='main-calendar' class="main-calendar"></div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
