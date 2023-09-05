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
                            Días disponibles para ___________
                        </p>
                        <p class="has-text-centered days-number pb-5">
                            18
                        </p>

                        <div class="field three-quarters-width">
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

                        <div class="columns full-width">
                            <div class="column is-3">
                                <button class="button full-width button-scs">
                                    <i class="bx bx-calendar"></i>
                                </button>
                            </div>
                            <div class="column is-flex is-align-items-center is-justify-content-center">
                                <p class="has-text-centered">Fecha Desde - Fecha Hasta</p>
                            </div>
                            <div class="column is-3">
                                <button class="button full-width button-scs">
                                    Solicitar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="column">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection