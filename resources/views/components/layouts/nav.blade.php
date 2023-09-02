@extends('components.layouts.app')

@section('style')
    <style>

        body {
            height: 100vh;
            background: var(--body-color);
        }

        /********************************************************************/

        .scs-sidebar .scs-sidebar-text {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }

        .scs-sidebar .scs-sidebar-image {
            min-width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /*************************** Sidebar ********************************/

        .scs-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            /* width: 250px; */
            width: 13vw;
            padding: 10px 14px;
            background: var(--sidebar-color);
        }

        .scs-sidebar li {
            height: 50px;   
            margin-top: 10px;
            list-style: none;
            display: flex;
            align-items: center;
        }

        .scs-sidebar li .scs-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            font-size: 20px;
        }

        .scs-sidebar li .scs-sidebar-text {
            color: var(--text-color);
            transition: var(--tran-02);
        }

        .scs-sidebar header {
            position: relative;
            padding-top: 5%;
        }

        .scs-sidebar .scs-sidebar-image-text img {
            width: 40px;
            border-radius: 6px;
        }

        .scs-sidebar header .scs-sidebar-image-text{
            display: flex;
            align-items: center;
        }

        header .scs-sidebar-image-text .scs-sidebar-header-text {
            display: flex;
            flex-direction: column;
        }

        .scs-sidebar-header-text .scs-sidebar-header-name {
            font-weight: 600;
        }

        .scs-sidebar-header-text .scs-sidebar-header-detail {
            margin-top: -2px;
        }

        .scs-sidebar header .scs-toggle {
            position: absolute;
            top: 50%;
            right: -25px;
            transform: translateY((-50%));
            height: 25px;
            width: 25px;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--sidebar-color);
            font-size: 20px;
        }

        .scs-sidebar li a {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 6px;
            transition: var(--tran-04);
        }

        .scs-sidebar li a:hover {
            background: var(--primary-color);
        }

        .scs-sidebar li a:hover .scs-icon,
        .scs-sidebar li a:hover .scs-sidebar-text {
            color: var(--sidebar-color);
        }

        /************** Content DIV ***************/
        .scs-content-div {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 100%;
            padding: 10px 14px;
        }

        .textarea {
            overflow: hidden;
            resize: none;
            min-height: 100px; /* Altura mínima del textarea */
        }

        /* Hide scroll bar from Chrome, Safari and Opera*/
        .textarea::-webkit-scrollbar {
            display: none;
        }

        /* Hide scroll bar from Firefox */
        .textarea {
            scrollbar-width: none;
        }

        /* Hide scroll bar from Edge and Internet Explorer */
        .textarea {
            -ms-overflow-style: none;
        }

        .scrollable-box {
            max-height: 100vh;
            overflow-y: auto;
        }

        /* Hide scroll bar from Chrome, Safari and Opera*/
        #queries::-webkit-scrollbar {
            display: none;
        }

        /* Hide scroll bar from Firefox */
        #queries {
            scrollbar-width: none;
        }

        /* Hide scroll bar from Edge and Internet Explorer */
        #queries {
            -ms-overflow-style: none;
        }

        /*****************************************************/
    </style>
@endsection


@section('content')
<div class="main-page">
    <div class="columns">
        {{-- Column for vertical nav bar --}}
        <div class="column is-2 px-5 full-height border-right">

            {{-- Image logo --}}
            <img class="solidocs-logo centered" src="{{ asset('storage/images/logo-solidocs.svg') }}" alt="SolidoCS-Logo">

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

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-folder-open nav-icon"></i>
                    <span class="pl-3">Documentos</span>
                </div>
            </div>

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-message nav-icon"></i>
                    <span class="pl-3">Tickets</span>
                </div>
            </div>

            <hr class="centered">

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-book-content nav-icon"></i>
                    <span class="pl-3">Dailys</span>
                </div>
            </div>

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-group nav-icon"></i>
                    <span class="pl-3">Usuarios</span>
                </div>
            </div>

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
        <div class="column is-10 px-0">
            <div class="full-width">
                <div class="top-header border-bottom">
                    {{-- Horizontal nav bar --}}
                    <div class="top-nav-bar half-height">
                        <div class="columns">
                            <div class="column is-8">
                                Usuario | Empresa | CUIT
                            </div>
                            <div class="column is-2">
                                Usuario | Editar usuario
                            </div>
                            <div class="column is-1">
                                Notificaciónes
                            </div>
                            <div class="column is-1">
                                Salir
                            </div>
                        </div>
                    </div>

                    {{-- Contact channels --}}
                    <div class="half-height">
                        <p>Canales de contacto | Solicitar asistencia | Contacto de mesa de ayuda | Contacto de ventas y pedidos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('asd')
        
    <nav class="scs-sidebar">
        
        <header>    
            
            <div class="scs-sidebar-image-text">
                <span class="scs-sidebar-image">
                    <img src="../images/logo.jpg" alt="" class="scs-img-icon">
                </span>
                
                <div class="scs-sidebar-text scs-sidebar-header-text">
                    <span class="scs-sidebar-header-name">
                        @auth
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 
                        @endauth
                    </span>
                    <span class="scs-sidebar-header-detail">
                        @if ($organization)
                        {{ $organization->business_name }}
                        @endif
                    </span>
                </div>
            </div>
        
            <i class="bx bx-chevron-right scs-toggle"></i>
        
            @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 6)
            <br>
            <a href="">
                <p class="has-text-centered">Cambiar organización</p>
            </a>
            @endif

        </header>

        <div class="scs-menu-bar">

            <dib class="scs-menu">

                <ul class="scs-menu-links">

                    <li class="scs-nav-link">
                        <a href="{{ route('home') }}">
                            <i class="bx bx-home-alt-2 scs-icon"></i>
                            <span class="scs-sidebar-text scs-nav-text">Inicio</span>
                        </a>
                    </li>

        
                    @auth
                        @if (Auth::user()->access_level_in_organization(session('organization_id')) 
                        && Auth::user()->access_level_in_organization(session('organization_id')) >= 3)
                            <li class="scs-nav-link">
                                <a href="#">
                                    <i class='bx bx-file scs-icon'></i>
                                    <span class="scs-sidebar-text scs-nav-text">SLA</span>
                                </a>
                            </li>
                            
                        @endif

                        @if (Auth::user()->access_level_in_organization(session('organization_id'))
                        && Auth::user()->access_level_in_organization(session('organization_id')) >= 2)
                            <li class="scs-nav-link">
                                <a href="#">
                                    <i class='bx bx-wallet-alt scs-icon'></i>
                                    <span class="scs-sidebar-text scs-nav-text">Facturas</span>
                                </a>
                            </li>
                        @endif
                        
                        <li class="scs-nav-link">
                            <a href="">
                                <i class="bx bx-message scs-icon"></i>
                                <span class="scs-sidebar-text scs-nav-text">Consultas</span>
                            </a>
                        </li>

                        <li class="scs-nav-link">
                            <a href="#">
                                <i class="bx bx-navigation scs-icon"></i>
                                <span class="scs-sidebar-text scs-nav-text">Tickets</span>
                            </a>
                        </li>

                        <li class="scs-nav-link">
                            <a href="#">
                                <i class="bx bx-bell scs-icon"></i>
                                <span class="scs-sidebar-text scs-nav-text">Notificaciones</span>
                            </a>
                        </li>

                        @if (Auth::user()->belongs_to('Solido Connecting Solutions'))
                            
                            <li class="scs-nav-link">
                                <a href="{{ route('documents') }}">
                                    <i class="bx bx-folder-open scs-icon"></i>
                                    <span class="scs-sidebar-text scs-nav-text">Documentos</span>
                                </a>
                            </li>

                            <li class="scs-nav-link">
                                <a href="#">
                                    <i class="bx bx-book-content scs-icon"></i>
                                    <span class="scs-sidebar-text scs-nav-text">Dailys</span>
                                </a>
                            </li>

                            <li class="scs-nav-link">
                                <a href="{{ route('users') }}">
                                    <i class="bx bx-group scs-icon"></i>
                                    <span class="scs-sidebar-text scs-nav-text">Usuarios</span>
                                </a>
                            </li>

                            <li class="scs-nav-link">
                                <a href="#">
                                    <i class="bx bxs-business scs-icon"></i>
                                    <span class="scs-sidebar-text scs-nav-text">Organizaciones</span>
                                </a>
                            </li>

                        @endif

                        <li class="scs-nav-link">
                            <a href="{{ route('logout') }}">
                                <i class="bx bx-log-out scs-icon"></i>
                                <span class="scs-sidebar-text scs-nav-text">Salir</span>
                            </a>
                        </li>

                    @endauth

                </ul>
            </dib>
        </div>
    </nav>

    <div class="main-content">
        @yield('main-content')
    </div>
   
@endsection
