@extends('components.layouts.nav')

@section('title')
    Dailys
@endsection

@section('main-content')
<div class="columns m-0">

    {{-- Calendar side bar --}}
    <div class="column is-3 calendar-column">
        <div class="container">
            <div class="calendar" id='calendar'>
                
                <div class="level-container">
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <button class="button" id="prevMonthBtn">&lt;</button>
                            </div>
                            <div class="level-item">
                                <p id="currentMonthYear">Mes Año</p>
                            </div>
                            <div class="level-item">
                                <button class="button" id="nextMonthBtn">&gt;</button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>Do</th>
                            <th>Lu</th>
                            <th>Ma</th>
                            <th>Mi</th>
                            <th>Ju</th>
                            <th>Vi</th>
                            <th>Sá</th>
                        </tr>
                    </thead>
                    <tbody id="calendarBody">
                        <!-- El contenido dinámico será insertado aquí -->
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- Main calendar --}}
    <div class="column">

    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentMonth = new Date().getMonth();
            let currentYear = new Date().getFullYear();
            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            function updateCalendar(month, year) {
                const firstDay = (new Date(year, month)).getDay();
                const daysInMonth = 32 - new Date(year, month, 32).getDate();

                let date = 1;
                let calendarBody = document.getElementById("calendarBody");
                calendarBody.innerHTML = ''; // Limpiar contenido anterior

                for (let i = 0; i < 6; i++) {
                    let row = document.createElement("tr");

                    for (let j = 0; j < 7; j++) {
                        let cell = document.createElement("td");
                        if (i === 0 && j < firstDay) {
                            cell.classList.add("empty-cell");
                            row.appendChild(cell);
                        } else if (date > daysInMonth) {
                            cell.classList.add("empty-cell");
                            row.appendChild(cell);
                        } else {
                            cell.innerText = date;
                            if (date === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()) {
                                cell.classList.add("today");
                            } 
                            row.appendChild(cell);
                            date++;
                        }
                    }
                    calendarBody.appendChild(row);
                }

                document.getElementById("currentMonthYear").innerText = `${monthNames[month]} ${year}`;
            }

            document.getElementById("prevMonthBtn").addEventListener("click", function() {
                currentMonth = (currentMonth - 1 + 12) % 12;
                if (currentMonth === 11) {
                    currentYear--;
                }
                updateCalendar(currentMonth, currentYear);
            });

            document.getElementById("nextMonthBtn").addEventListener("click", function() {
                currentMonth = (currentMonth + 1) % 12;
                if (currentMonth === 0) {
                    currentYear++;
                }
                updateCalendar(currentMonth, currentYear);
            });

            updateCalendar(currentMonth, currentYear);
        });
    </script>
@endsection
