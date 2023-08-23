@extends('components.layouts.app')

@section('title')
    Verificación de cuenta
@endsection

@section('content')

    <div class="hero is-fullheight has-background-light">
        <div class="hero-body is-flex justify-content-center">
            <div class="container">
                <div class="columns is-centered is-vcentered">
    
                    <div class="column">
                        
                        @if ($verified == true)
                            <div class="columns is-centered is-vcentered">
                                <div class="column is-two-fifths">
                                    <div class="notification is-success">
                                        <p class="has-text-centered">
                                            Usuario verificado correctamente!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="columns is-centered is-vcentered">
                                <div class="column is-two-fifths">
                                    <div class="notification is-danger">
                                        <p class="has-text-centered">
                                            El enlace se encuentra vencido, si desea verificar su
                                            cuenta contacte con un técnico.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif   
                        
                        <div class="columns is-centered is-vcentered mt-4">
                            <a href="{{ route('auth.login') }}">
                                <button class="button is-link">
                                    Iniciar sesión
                                </button>
                            </a>
                        </div>
                                
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection