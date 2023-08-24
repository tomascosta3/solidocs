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
            <!-- List item for the logout button/link -->
            <li>
                <!-- 
                "Logout" link. When clicked:
                1. It prevents the default behavior of the link (which would be navigating to "#").
                2. Submits the form with the ID 'logout-form'.
                -->
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-log-out navbar-icon"></i>
                    <span>Cerrar sesión</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- 
    Hidden form that performs the logout action.
    The form is hidden because we don't need the user to interact with it directly. 
    It's programmatically submitted when the user clicks the link above.
    -->
    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
        @csrf
    </form>

    <div class="main-content">
        @yield('main-content')
    </div>

@endsection