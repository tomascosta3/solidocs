@extends('components.layouts.app')

@section('content')
<div class="main-page">
    <div class="columns">
        {{-- Column for vertical nav bar --}}
        <div class="column is-2 px-5 full-height border-right vertical-navbar" id="vertical-nav-bar">

            {{-- Image logo --}}
            <img id="logo" class="solidocs-logo centered" src="{{ asset('storage/images/logo-solidocs.svg') }}"
            data-light="{{ asset('storage/images/logo-solidocs.svg') }}"
            data-dark="{{ asset('storage/images/solidocs-white-logo.png') }}"
            alt="SolidoCS-Logo">

            <hr class="centered">

            <a href="{{ route('home') }}">
                <div class="box p-2 mb-4 invisible-box {{ request()->routeIs('home') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-home-alt-2 nav-icon"></i>
                        <span class="pl-3">Inicio</span>
                    </div>
                </div>
            </a>

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-wallet-alt nav-icon"></i>
                    <span class="pl-3">Facturas y comprobantes</span>
                </div>
            </div>

            <a href="{{ route('documents') }}">
                <div class="box p-2 mb-4 invisible-box {{ request()->routeIs('documents') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-folder-open nav-icon"></i>
                        <span class="pl-3">Documentos</span>
                    </div>
                </div>
            </a>

            {{-- <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-message nav-icon"></i>
                    <span class="pl-3">Tickets</span>
                </div>
            </div> --}}

            <hr class="centered">

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-book-content nav-icon"></i>
                    <span class="pl-3">Dailys</span>
                </div>
            </div>

            <a href="{{ route('users') }}">
                <div class="box p-2 mb-4 invisible-box {{ request()->routeIs('users') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-group nav-icon"></i>
                        <span class="pl-3">Usuarios</span>
                    </div>
                </div>
            </a>

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bxs-business nav-icon"></i>
                    <span class="pl-3">Organizaciones</span>
                </div>
            </div>

            <hr class="centered">

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-help-circle nav-icon"></i>
                    <span class="pl-3">Ayuda</span>
                </div>
            </div>

            <hr class="centered">

            <a href="{{ route('logout') }}">
                <div class="box p-2 mb-4 invisible-box">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-log-out nav-icon"></i>
                        <span class="pl-3">Salir</span>
                    </div>
                </div>
            </a>

        </div>

        {{-- Column for horizontal nav bar and main content --}}
        <div class="column is-10 px-0 principal-page">
            <div class="full-width">
                <div class="top-header">
                    
                    {{-- Horizontal nav bar --}}
                    <div class="top-nav-bar">
                        <div class="columns is-vcentered">

                            {{-- Organization --}}
                            <div class="column pt-1 pl-5 is-flex">
                                <div class="navbar-item is-align-items-center">
                                    <ul>
                                        <li>
                                            <p class="is-size-5 has-text-weight-bold">{{ $organization->business_name }}</p>
                                        </li>
                                        <li>
                                            <p>CUIT: {{ $organization->cuit }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- User --}}
                            <div class="column is-4 pt-1 is-flex is-justify-content-center">
                                <div class="navbar-item is-align-items-center">
                                    <div class="columns is-vcentered">
                                        <div class="column is-2">
                                            <i class="bx bx-user-circle nav-icon user-icon"></i>
                                        </div>
                                        <div class="column is-10">
                                            <p>¡Hola! {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                            <p>Perfil:
                                                @switch(Auth::user()->access_level_in_organization(session('organization_id')))
                                                    @case(1) Cliente @break
                                                    @case(2) Administración @break
                                                    @case(3) Facturación @break
                                                    @case(4) Dueño @break
                                                    @case(5) Mesa de ayuda @break
                                                    @case(6) Administración @break
                                                    @case(7) Facturación @break
                                                    @case(8) Administrador @break
                                                    @default Usuario
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="separator"></div>
                            
                            {{-- Notifications --}}
                            <div class="column is-1 pt-1">
                                <div class="navbar-item is-align-items-center is-justify-content-center has-text-centered is-flex is-align-items-center">
                                    <i class="bx bx-bell notification-icon"></i>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- Theme toggle button --}}
                            <div class="column is-1 pt-1">
                                <div class="navbar-item is-align-items-center is-justify-content-center has-text-centered is-flex is-align-items-center">
                                    <button id="theme-toggle" class="hidden-button">
                                        <i class="bx bx-sun notification-icon"></i>
                                        <i class="bx bx-moon notification-icon" style="display: none"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- Logout button --}}
                            <div class="column is-1 pt-1">
                                <a href="{{ route('logout') }}">
                                    <div class="navbar-item has-text-centered is-flex is-align-items-center">
                                        <i class="bx bx-log-out nav-icon"></i>
                                        <span class="pl-3">Salir</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Contact channels --}}
                    <div class="channels">
                        <div class="columns is-vcentered m-0 max-height-allowed">
                            <div class="column is-2 py-0">
                                <p>Horarios de atención al cliente</p>
                            </div>
                            <div class="column py-0">
                                <ul>
                                    <li>🕘 Lunes a Viernes: 9:00 - 18:00 hs</li>
                                    <li>🕘 Sábados: 9:00 - 13:00 hs</li>
                                </ul>
                            </div>
                    
                            <div class="column py-0 is-flex is-justify-content-center is-justify-content-space-evenly is-align-items-center"> 
                                
                                <div class="column py-0">
                                    <a href="https://soporte.solidcloud.com.ar/" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-2" src="{{ asset('storage/images/zammad-logo.svg') }}" alt="Zammad-logo">
                                            <p>Realizar ticket</p>
                                        </div>
                                    </a>
                                </div>
                    
                                <div class="column py-0">
                                        <a href="https://wa.me/+542324683467" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-2" src="{{ asset('storage/images/whatsapp-logo.svg') }}" alt="WhatsApp-logo">
                                            <p>Mesa de ayuda</p>
                                        </div>
                                    </a>
                                </div>
                    
                                <div class="column py-0">
                                    <a href="https://wa.me/+542324696334" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-5" src="{{ asset('storage/images/whatsapp-logo.svg') }}" alt="WhatsApp-logo">
                                            <p>Ventas</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- Content --}}
                @yield('main-content')

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var toggleButton = document.getElementById('theme-toggle');
    var logo = document.getElementById('logo');

    var sunIcon = toggleButton.querySelector('.bx-sun');
    var moonIcon = toggleButton.querySelector('.bx-moon');

    toggleButton.addEventListener('click', function() {
        var body = document.body;
        var lightLogo = logo.getAttribute('data-light');
        var darkLogo = logo.getAttribute('data-dark');

        if(body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            sunIcon.style.display = 'inline-block';
            moonIcon.style.display = 'none';
            logo.src = lightLogo;
            localStorage.setItem('theme', 'light');
        } else {
            body.classList.add('dark-mode');
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline-block';
            logo.src = darkLogo;
            localStorage.setItem('theme', 'dark');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline-block';
            logo.src = "{{ asset('storage/images/solidocs-white-logo.png') }}"; 
        } else {
            sunIcon.style.display = 'inline-block';
            moonIcon.style.display = 'none';
        }
    });
</script>
@endsection