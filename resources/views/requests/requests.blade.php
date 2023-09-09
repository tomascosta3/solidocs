@extends('components.layouts.nav')

@section('title')
    Solicitudes
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            @if (session('success') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-success">
                        <p class="has-text-centered">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('problem') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-danger">
                        <p class="has-text-centered">{{ session('problem') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="columns is-vcentered is-centered">
                {{-- Show days available and request --}}
                <div class="column is-6">
                    <form action="{{ route('requests.store') }}" method="post">
                        @csrf
                        <div class="box secondary-background is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                            <p class="has-text-centered is-size-3 pb-5">
                                Días disponibles para <span id="days-type"></span>
                            </p>
                            <p class="has-text-centered days-number pb-5" id="days-display"></p>
    
                            <div class="field three-quarters-width pb-4">
                                <div class="control">
                                    <div class="select full-width">
                                        <select name="option_request" id="option_request" class="full-width select-scs">
                                            @foreach ($days as $day)
                                            <option value="{{ $day->type }}" 
                                                data-days="{{ auth()->user()->days_of_type($day->type)->pivot->days_available }}"
                                                data-need-file="{{ auth()->user()->days_of_type($day->type)->need_file }}">
                                                {{ $day->type }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->create->first('option_request'))
                                    <small style="color: red">{{ $errors->create->first('option_request') }} </small>
                                @endif
                            </div>

                            {{-- Input file block --}}
                            <div class="field" id="field-block">
                                <div class="file has-name is-fullwidth">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="file" id="inputFile">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="bx bx-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Seleccionar certificado
                                            </span>
                                        </span>
                                        <span class="file-name">
                                            Cargue el certificado aquí...
                                        </span>
                                    </label>
                                </div>
                                @if ($errors->create->first('file'))
                                    <small style="color: red">{{ $errors->create->first('file') }} </small>
                                @endif
                            </div>
    
                            <div class="field">
                                <p class="is-size-5">Seleccionar fecha / período</p>
                            </div>
    
                            <div class="columns full-width">
                                
                                <div class="column">
                                    <span>Desde</span>
                                    <input class="input" type="datetime-local" name="start_date"/>
                                    @if ($errors->create->first('start_date'))
                                        <small style="color: red">{{ $errors->create->first('start_date') }} </small>
                                    @endif
                                </div>
    
                                <div class="column">
                                    <span>Hasta</span>
                                    <input class="input" type="datetime-local" name="end_date">
                                    @if ($errors->create->first('end_date'))
                                        <small style="color: red">{{ $errors->create->first('end_date') }} </small>
                                    @endif
                                </div>
                            </div>
                            <div class="column is-3">
                                <button class="button full-width button-scs">
                                    Solicitar
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div>

                {{-- Column for request's history --}}
                <div class="column">
                    <div class="box secondary-background is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                        <p class="has-text-centered is-size-3 pb-5">
                            Historial de solicitudes
                        </p>

                        <div class="box is-shadowless p-2 mb-4 full-width categories">
                            <div class="columns">
                                <div class="column">
                                    <p>Tipo</p>
                                </div>
                                <div class="column">
                                    <p>Días</p>
                                </div>
                                <div class="column">
                                    <p>Desde</p>
                                </div>
                                <div class="column">
                                    <p>Hasta</p>
                                </div>
                                <div class="column">
                                    <p>Estado</p>
                                </div>
                            </div>
                        </div>

                        <div class="requests-history full-width">

                            @if ($day_requests->isEmpty())
                            <div class="box is-shadowless p-2 full-width mb-2">
                                <div class="columns">
                                    <div class="column">
                                        <p class="has-text-centered">Aún no creaste solicitudes</p>
                                    </div>
                                </div>
                            </div>
                            @else
                            @foreach ($day_requests as $day_request)
                            <a href="{{ route('requests.view', ['id' => $day_request->id]) }}">
                                <div class="box is-shadowless p-2 full-width mb-2">
                                    <div class="columns">
                                        <div class="column">
                                            <p>{{ $day_request->day->type }}</p>
                                        </div>
                                        <div class="column">
                                            <p>{{ $day_request->requested_days }}</p>
                                        </div>
                                        <div class="column">
                                            <p>{{ $day_request->formatted_start_date() }}</p>
                                        </div>
                                        <div class="column">
                                            <p>{{ $day_request->formatted_end_date() }}</p>
                                        </div>
                                        <div class="column">
                                            <p>
                                                @switch($day_request->status)
                                                    @case('Pending') Pendiente @break
                                                    @case('Approved') Aprobado @break
                                                    @case('Rejected') Rechazado @break
                                                    @default Sin estado
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div> 
                            </a>
                            @endforeach
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('option_request');
            const daysDisplay = document.getElementById('days-display');
            const daysTypeSpan = document.getElementById('days-type');
            const fieldBlock = document.getElementById('field-block');

            selectElement.addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let days = selectedOption.getAttribute('data-days');
                let selectedType = this.options[this.selectedIndex].text;
                let needFile = selectedOption.getAttribute('data-need-file') == true;

                if (days !== null) {
                    daysDisplay.textContent = days;
                } else {
                    daysDisplay.textContent = '';
                }
                daysTypeSpan.textContent = selectedType;

                if (needFile) {
                    fieldBlock.style.display = 'block';
                } else {
                    fieldBlock.style.display = 'none';
                }
            });

            selectElement.dispatchEvent(new Event('change'));
        });
    </script>
@endsection