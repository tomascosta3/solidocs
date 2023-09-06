@extends('components.layouts.nav')

@section('title')
    Solicitudes
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">
            <div class="columns is-vcentered is-centered">
                {{-- Show days available and request --}}
                <div class="column is-5">
                    <div class="box secondary-background is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                        <p class="has-text-centered is-size-3 pb-5">
                            Días disponibles para Vacaciones
                        </p>
                        <p class="has-text-centered days-number pb-5">
                            {{ auth()->user()->vacations()->pivot->days_available }}
                        </p>

                        <div class="field three-quarters-width pb-4">
                            <div class="control">
                                <div class="select full-width">
                                    <select name="option_request" id="option_request" class="full-width select-scs">
                                        <option value="">Vacaciones</option>
                                        <option value="">Licencia por maternidad</option>
                                        <option value="">Licencia por enfermedad</option>
                                    </select>
                                </div>
                            </div>
                            @if ($errors->create->first('option_request'))
                                <small style="color: red">{{ $errors->create->first('option_request') }} </small>
                            @endif
                        </div>

                        <div class="field">
                            <p class="is-size-5">Seleccionar fecha / período</p>
                        </div>

                        <div class="columns full-width">
                            
                            <div class="column">
                                <span>Desde</span>
                                <input class="input" type="datetime-local"/>
                            </div>

                            <div class="column">
                                <span>Hasta</span>
                                <input class="input" type="datetime-local">
                            </div>
                        </div>
                        <div class="column is-3">
                            <button class="button full-width button-scs">
                                Solicitar
                            </button>
                        </div>

                    </div>
                </div>

                {{-- Column for request's history --}}
                <div class="column is-offset-1">
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

                        <div class="box is-shadowless p-2 full-width mb-2">
                            <div class="columns">
                                <div class="column">
                                    <p>Vacaciones</p>
                                </div>
                                <div class="column">
                                    <p>4</p>
                                </div>
                                <div class="column">
                                    <p>05/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>08/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>Aprobado</p>
                                </div>
                            </div>
                        </div>

                        <div class="box is-shadowless p-2 full-width mb-2">
                            <div class="columns">
                                <div class="column">
                                    <p>Vacaciones</p>
                                </div>
                                <div class="column">
                                    <p>15</p>
                                </div>
                                <div class="column">
                                    <p>10/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>24/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>Aprobado</p>
                                </div>
                            </div>
                        </div>

                        <div class="box is-shadowless p-2 full-width mb-2">
                            <div class="columns">
                                <div class="column">
                                    <p>Vacaciones</p>
                                </div>
                                <div class="column">
                                    <p>2</p>
                                </div>
                                <div class="column">
                                    <p>28/09/2023</p>
                                </div>
                                <div class="column">
                                    <p>29/09/2023</p>
                                </div>
                                <div class="column">
                                    <p>Aprobado</p>
                                </div>
                            </div>
                        </div>

                        <div class="box is-shadowless p-2 full-width mb-2">
                            <div class="columns">
                                <div class="column">
                                    <p>Vacaciones</p>
                                </div>
                                <div class="column">
                                    <p>6</p>
                                </div>
                                <div class="column">
                                    <p>01/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>06/10/2023</p>
                                </div>
                                <div class="column">
                                    <p>Rechazado</p>
                                </div>
                            </div>
                        </div>

                        <div class="box is-shadowless p-2 full-width mb-2">
                            <div class="columns">
                                <div class="column">
                                    <p>Vacaciones</p>
                                </div>
                                <div class="column">
                                    <p>5</p>
                                </div>
                                <div class="column">
                                    <p>05/09/2023</p>
                                </div>
                                <div class="column">
                                    <p>09/09/2023</p>
                                </div>
                                <div class="column">
                                    <p>Pendiente</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection