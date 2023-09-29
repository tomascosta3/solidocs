@extends('components.layouts.nav')

@section('title')
    Agenda
@endsection

@section('style')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

{{-- Choices --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>

    // Function to close the event creation modal and reset form values.
    function closeModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.remove('is-active');
        document.getElementById('eventForm').reset();
        document.getElementById('weeklyOptions').classList.add('is-hidden');
        document.getElementById('customDateOption').classList.add('is-hidden');
        document.getElementById('repeatDurationSection').classList.add('is-hidden');
    }

    // Function to open the modal for a new calendar creation.
    function openNewCalendarModal() {
        const modal = document.getElementById('new-calendar');
        modal.classList.add('is-active');
    }

    // Function to close the modal for a new calendar creation and reset form values.
    function closeNewCalendarModal() {
        const modal = document.getElementById('new-calendar');
        modal.classList.remove('is-active');
        document.getElementById('new-calendar-form').reset();
    }

    // Function to close the event view modal and reset view form values.
    function closeEventModal() {
        document.getElementById('eventDetailModal').classList.remove('is-active');
        document.getElementById('eventViewForm').reset();
    }

    // Convert a Date object to "datetime-local" input format.
    function toDatetimeLocalFormat(dateObj) {
        let date = ('0' + dateObj.getDate()).slice(-2);
        let month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
        let year = dateObj.getFullYear();
        let hours = ('0' + dateObj.getHours()).slice(-2);
        let minutes = ('0' + dateObj.getMinutes()).slice(-2);

        return `${year}-${month}-${date}T${hours}:${minutes}`;
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

    // Format a date to "datetime-local" input format.
    function formatDate(date) {

        var year = date.getFullYear(),
            month = ('0' + (date.getMonth() + 1)).slice(-2),
            day = ('0' + date.getDate()).slice(-2),
            hour = ('0' + date.getHours()).slice(-2),
            minute = ('0' + date.getMinutes()).slice(-2);

        return year + '-' + month + '-' + day + 'T' + hour + ':' + minute;
    }

    // Set event users in select from view event modal.
    function fetchSetEventUsers(event_id) {
        fetch(`/events/${event_id}/users`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            eventUsersChoices.clearChoices();
            const choicesArray = data.map(user => {
                return {
                    value: user.id,
                    label: user.first_name,
                    selected: true // Marcar todos los usuarios como seleccionados
                };
            });
            eventUsersChoices.setChoices(choicesArray, 'value', 'label', true);
        })
        .catch(error => console.error('Hubo un error obteniendo los usuarios:', error));
    }

    // Initializing the side calendar.
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var sideCalendar = new FullCalendar.Calendar(calendarEl, {
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
        sideCalendar.render();
    });

    // Global variable for calendar.
    var calendar;

    // All events data.
    var allEvents = @json($all_events);

    // Initializing the main calendar.
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('main-calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                center: 'dayGridMonth,dayGridWeek,timeGridOneDay,listWeek' // buttons for switching between views
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
                },
                listWeek: {
                    buttonText: 'Agenda',
                },
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
            eventSources: Object.keys(allEvents).map(function(calendarId) {
                return {
                    id: calendarId,
                    events: allEvents[calendarId],
                };
            }),
            eventClick: function(info) {
                // Show modal
                document.getElementById('eventDetailModal').classList.add('is-active');
                document.getElementById('eventTitle').value = info.event.title;
                document.getElementById('eventTypeSelect').value = info.event.extendedProps.event_type_id;
                document.getElementById('calendarEvent').textContent = info.event.extendedProps.calendar.name;
                document.getElementById('startDate').value = toDatetimeLocalFormat(info.event.start);
                document.getElementById('endDate').value = toDatetimeLocalFormat(info.event.end);

                if(info.event.extendedProps.reminder === null) {
                    document.getElementById('reminderSelect').value = "none";
                } else {
                    document.getElementById('reminderSelect').value = info.event.extendedProps.reminder;
                }
                document.getElementById('location').value = info.event.extendedProps.location;
                document.getElementById('eventComment').textContent = info.event.extendedProps.comment;

                fetchSetEventUsers(info.event.id);
            },
        });
        calendar.render();
    });

    // Function to toggle visibility of events for a given calendar ID.
    function toggleCalendarEvents(calendarId) {

        var eventSource = calendar.getEventSourceById(calendarId.toString());

        var checkbox = document.querySelector('input[data-calendar-id="' + calendarId + '"]');
        
        if (eventSource) {
            eventSource.remove();
            checkbox.checked = false;
        } else {
            calendar.addEventSource({
                id: calendarId.toString(),
                events: allEvents[calendarId]
            });
            checkbox.checked = true;
        }
    }

    // Event listener for selecting users.
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
            <form id="eventForm" action="{{ route('calendars.events.store') }}" method="post">
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
                    <div class="column is-6">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select name="calendar_id" id="calendar-select" required>
                                        @foreach($calendars as $calendar)
                                            <option value="{{ $calendar->id }}"
                                                @if ($calendar->group)
                                                    data-users="{{ json_encode($calendar->group->users) }}"
                                                    @if (auth()->user()->groups()->where('group_id', $calendar->group->id)->first()->pivot->role == 'viewer')
                                                        disabled
                                                    @endif
                                                @endif
                                                >
                                            {{ $calendar->name }}</option>
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

                <div class="field">
                    <label for="collaborators" class="label">Colaboradores:</label>
                    <div class="columns is-vcentered">
                        <div class="column">
                            <!-- Checkbox "Todos" -->
                            <div class="field">
                                <label class="checkbox" for="all">
                                    <input type="checkbox" name="all" id="all">
                                    Todos
                                </label>
                            </div>
                            
                            <!-- Checkbox "Solo yo" -->
                            <div class="field">
                                <label class="checkbox" for="only_me">
                                    <input type="checkbox" name="only_me" id="only_me">
                                    Solo yo
                                </label>
                            </div>
                        </div>
                        <div class="column">
                            <!-- Select de usuarios -->
                            <select name="users[]" id="users" multiple></select>
                        </div>
                    </div>
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
                
                <div class="columns">
                    {{-- Event repeat --}}
                    <div class="column is-narrow">
                        <div class="field">
                            <label class="label">¿Repetir evento?</label>
                            <div class="control">
                                <div class="select">
                                    <select id="repeatOption" name="repeat_option">
                                        <option value="no-repeat">No repetir</option>
                                        <option value="daily">Diario</option>
                                        <option value="weekly">Semanal</option>
                                        <option value="custom">Personalizado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Repetition period --}}
                    <div class="column is-hidden" id="repeatDurationSection">
                        <div class="field">
                            <label class="label">Duración de la repetición:</label>

                            <div class="columns is-vcentered is-mobile">
                                <div class="column is-narrow">
                                    <div class="control">
                                        <input class="input" type="number" id="repeatDurationValue" name="repeat_duration_value" min="1">
                                    </div>
                                </div>

                                <div class="column">
                                    <div class="control">
                                        <div class="select is-fullwidth">
                                            <select id="repeatDurationUnit" name="repeat_duration_unit">
                                                <option value="days" id="days-option">Días</option>
                                                <option value="weeks" od="weeks-option">Semanas</option>
                                                <option value="months">Meses</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                {{-- Weekly options (will be displayed only if the "Weekly" option is selected) --}}
                <div class="field is-hidden" id="weeklyOptions">
                    <label class="label">Días:</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Do"> Do</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Lu"> Lu</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Ma"> Ma</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Mi"> Mi</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Ju"> Ju</label>
                    <label class="checkbox mr-2"><input type="checkbox" name="week_days[]" value="Vi"> Vi</label>
                    <label class="checkbox"><input type="checkbox" name="week_days[]" value="Sa"> Sa</label>
                </div>

                {{-- Custom option (will be displayed only if "Custom" is selected) --}}
                <div class="field is-hidden" id="customDateOption">
                    <label class="label">Fecha de repetición:</label>
                    <div class="control">
                        <input class="input" type="date" name="custom_repeat_date">
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

@if ($calendar)  
{{-- View event modal --}}
<div class="modal" id="eventDetailModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <input type="text" id="eventTitle" class="discreet-input">
            <button class="delete" aria-label="close" onclick="closeEventModal()"></button>
        </header>
        <section class="modal-card-body">
            <form id="eventViewForm" action="#" method="post">
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
                                    <select id="eventTypeSelect" name="event_type_id" required>
                                        @foreach($event_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <span id="calendarEvent"></span>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label" for="start_date">Desde</label>
                            <div class="control">
                                <input class="input" type="datetime-local" name="start_date" id="startDate" required>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label" for="end_date">Hasta</label>
                            <div class="control">
                                <input class="input" type="datetime-local" name="end_date" id="endDate" required>
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

                <div class="field">
                    <label for="collaborators" class="label">Colaboradores:</label>
                    <!-- Event users select -->
                    <select id="event-users-select" multiple></select>
                </div>

                <div class="columns is-vcentered is-mobile">
                    <div class="column is-narrow">
                        <label class="label" for="reminder">Recordatorio:</label>
                    </div>
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select name="reminder" id="reminderSelect">
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
                        <input class="input" type="text" name="location" id="location">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="comment">Comentario:</label>
                    <div class="control">
                        <textarea class="textarea" name="comment" id="eventComment"></textarea>
                    </div>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-success" type="submit" form="eventForm">Modificar</button>
            <button class="button" type="button" onclick="closeEventModal()">Cancelar</button>
        </footer>
    </div>
</div>
@endif


{{-- Main Page --}}
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
                    {{-- <a href="{{ route('calendars.show', ['calendar_id' => $calendar->id]) }}"> --}}
                        <div class="box p-2 is-shadowless has-text-centered {{ !$loop->last ? 'mb-2' : '' }}"
                            @if ($calendar->group)
                            style="background-color: {{ $calendar->group->color }}; color: {{ get_text_color($calendar->group->color) }};"
                            @endif
                            >
                            <label><input type="checkbox" class="mr-3" data-calendar-id="{{ $calendar->id }}" onclick="toggleCalendarEvents({{ $calendar->id }})" checked>{{ $calendar->name }}</label>
                        </div>
                    {{-- </a> --}}
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


@section('scripts')
    @parent
    <script>

        // Select collaborators users
        const userChoices = new Choices('#users', {
            removeItemButton: true,
            noChoicesText: 'No hay usuarios disponibles',
        });

        const calendarSelect = document.querySelector('#calendar-select');

        // When calendar selected change, update users list.
        calendarSelect.addEventListener('change', function(e) {

            userChoices.clearStore();

            const calendarId = e.target.value;

            // Verify if there is a selected value.
            if (!calendarId) return;

            // Get user's list based on selected calendar.
            fetch(`/calendars/${calendarId}/users`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                userChoices.clearChoices();

                userChoices.setChoices(data, 'id', 'first_name', true);
            })
            .catch(error => console.error('Hubo un error obteniendo los usuarios:', error));
        });

        // Display weekly/custom options.
        document.getElementById('repeatOption').addEventListener('change', function() {
            // Hide all options first.
            document.getElementById('weeklyOptions').classList.add('is-hidden');
            document.getElementById('customDateOption').classList.add('is-hidden');
            
            // Shows the selected option.
            if (this.value === 'weekly') {
                document.getElementById('weeklyOptions').classList.remove('is-hidden');
            } else if (this.value === 'custom') {
                document.getElementById('customDateOption').classList.remove('is-hidden');
            }

            if (this.value !== 'no-repeat') {
                document.getElementById('repeatDurationSection').classList.remove('is-hidden');
            } else {
                document.getElementById('repeatDurationSection').classList.add('is-hidden');
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const allCheckbox = document.getElementById('all');
            const onlyMeCheckbox = document.getElementById('only_me');
            const userSelect = document.getElementById('users');

            // Listener for the "Todos" checkbox.
            allCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If "Everyone" is selected, uncheck "Only me".
                    onlyMeCheckbox.checked = false;
                }
                toggleUserSelect();
            });

            // Listener for the "Only me" checkbox.
            onlyMeCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If "Only Me" is selected, uncheck "Everyone".
                    allCheckbox.checked = false;
                }
                toggleUserSelect();
            });

            // Function to show/hide selected users.
            function toggleUserSelect() {
                const choicesContainer = userSelect.closest('.choices');
                if (allCheckbox.checked || onlyMeCheckbox.checked) {
                    choicesContainer.style.display = 'none';
                } else {
                    choicesContainer.style.display = 'block';
                }
            }

            // Simulate a change on the calendar select to load users for the first calendar.
            calendarSelect.dispatchEvent(new Event('change'));

            // Initial call to set the correct state on page load.
            toggleUserSelect();
        });

        // Function to open the event creation modal with selected date.
        function openModal(date) {
            const modal = document.getElementById('eventModal');
            modal.classList.add('is-active');
            document.getElementById('selectedDate').innerText = date;
            document.getElementById('dateInput').value = date;

            // Simulate a change on the calendar select to load users for the first calendar.
            calendarSelect.dispatchEvent(new Event('change'));
        }

        // Event's users select.
        const eventUsersChoices = new Choices('#event-users-select', {
            removeItemButton: true,
            noChoicesText: 'No hay usuarios disponibles',
        });

    </script>
@endsection