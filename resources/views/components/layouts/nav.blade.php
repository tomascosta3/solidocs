@extends('components.layouts.app')

@section('style')
    <style>
        
        *{
            font-family: Arial;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Colors */
            --body-color: #E4E9F7;
            --sidebar-color: #fff;
            --primary-color: #0089d8;
            --primary-color-light: #f6f5ff;
            --toggle-color: #ddd;
            --text-color: #707070;

            /* Transition */
            --tran-02: all 0.2s ease;
            --tran-03: all 0.3s ease;
            --tran-04: all 0.4s ease;
            --tran-05: all 0.5s ease;
        }

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
    </style>
@endsection


@section('content')
        
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
                        @auth
                            {{ $organization->business_name }}
                        @endauth
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
                                <a href="#">
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
