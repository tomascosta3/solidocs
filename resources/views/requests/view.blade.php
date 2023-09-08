@extends('components.layouts.nav')

@section('title')
    Solicitud
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

                {{-- Show request data --}}
                <div class="column is-5">
                    
                    <div class="box secondary-background is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                        <p class="has-text-centered is-size-3 pb-5">
                            {{ $day_request->requester->first_name . ' ' . $day_request->requester->last_name }}
                            solicita <strong>{{ $day_request->requested_days }}</strong> días por <strong>{{ $day_request->day->type }}</strong>
                        </p>

                        <div class="columns full-width">                      
                            <div class="column">
                                <span>Desde</span>
                                <input class="input" type="text" name="start_date" value="{{ $day_request->formatted_start_date_complete() }}" readonly/>
                            </div>

                            <div class="column">
                                <span>Hasta</span>
                                <input class="input" type="text" name="end_date" value="{{ $day_request->formatted_end_date_complete() }}" readonly>
                            </div>
                        </div>

                        <p class="is-size-4">
                            Estado de solicitud: 
                            <strong>
                                @switch($day_request->status)
                                    @case('Pending') Pendiente @break
                                    @case('Approved') Aprobado @break
                                    @case('Rejected') Rechazado @break
                                    @default Sin estado
                                @endswitch
                            </strong>
                        </p>
                    </div>
                    
                </div>

                {{-- Chat employer-employee --}}
                <div class="column is-offset-1">
                    <div class="box secondary-background">
                        <div class="message p-2">
                            Mensaje del empleado
                        </div>

                        <form action="#" method="post">
                            @csrf

                            <div class="columns">
                                <div class="column is-11 pr-0">
                                    <div class="field">
                                        <div class="control">
                                            <textarea class="textarea request-textarea" name="message" placeholder="Escribe un mensaje..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="column is-1 is-flex is-flex-direction-column is-justify-content-center">
                                    <div class="field is-grouped is-grouped-centered is-flex-direction-column">
                                        {{-- Approve button --}}
                                        <div class="control mb-3">
                                            <a href="#">
                                                <button class="button is-success" type="button">
                                                    <span class="icon">
                                                        <i class="bx bx-check-circle"></i>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>

                                        {{-- Reject button --}}
                                        <div class="control mb-3">
                                            <a href="#">
                                                <button class="button is-danger" type="button">
                                                    <span class="icon">
                                                        <i class="bx bx-x-circle"></i>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>

                                        {{-- Send button --}}
                                        <div class="control">
                                            <a href="#">
                                                <button class="button is-link" type="button">
                                                    <span class="icon">
                                                        <i class="bx bx-send"></i>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection