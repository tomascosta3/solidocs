@extends('components.layouts.app')

@section('content')

    <nav>
        <ul class="top-menu">
            <li>
                <a href="{{ route('home') }}">
                    <i class="bx bx-home navbar-icon"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-folder-open navbar-icon"></i>
                    <span>Documentos</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-book-content navbar-icon"></i>
                    <span>Dailys</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-buildings navbar-icon"></i>
                    <span>Organizaciones</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-group navbar-icon"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-wallet navbar-icon" ></i>
                    <span>Facturación</span>
                </a>
            </li>
        </ul>
        <ul class="bottom-menu">
            <li>
                <a href="">
                    <i class="bx bx-user-circle navbar-icon"></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="bx bx-log-out navbar-icon"></i>
                    <span>Cerrar sesión</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="main-content">
        @yield('main-content')
    </div>

@endsection