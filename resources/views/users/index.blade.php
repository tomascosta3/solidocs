@extends('components.layouts.nav')

@section('title')
    Usuarios
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                <div class="column">
                    <div class="box secondary-background">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-3">
                                    <strong>
                                        Usuarios
                                    </strong>
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3 search">
                            <form action="#" method="get">
                                <div class="columns is-vcentered is-centered">
                                    <div class="column is-7">
                                        <div class="field has-addons">
                                            <div class="control has-icons-left is-expanded">
                                                <input class="input" type="text" name="search" placeholder="Buscar..." value="{{ session('filter') }}">
                                                <span class="icon is-small is-left">
                                                    <i class="bx bx-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <div class="control">
                                                <div class="select">
                                                    <select name="search_option" id="search_option">
                                                        <option value="name"
                                                        @if (session('search_option') == "name")
                                                            selected
                                                        @endif
                                                        >Nombre</option>
                                                        <option value="organization"
                                                        @if (session('search_option') == "organization")
                                                            selected
                                                        @endif
                                                        >Organización</option>
                                                        <option value="email"
                                                        @if (session('search_option') == "email")
                                                            selected
                                                        @endif
                                                        >Correo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-1">
                                        <button class="button is-link is-pulled-right" type="submit">
                                            <span class="icon">
                                                <i class="bx bx-search-alt-2"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="column is-1">
                                        <a href="{{ route('users.create') }}">
                                            <button class="button is-success is-pulled-right" type="button">
                                                <span class="icon">
                                                    <i class="bx bx-plus"></i>
                                                </span>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
            
                        <div class="box p-2 mb-2 is-shadowless categories">
                            <div class="columns is-vcentered">
                                <div class="column is-2">
                                    <p>Nombre</p>
                                </div>
                                <div class="column">
                                    <p>Organización</p>
                                </div>
                                <div class="column">
                                    <p>Correo electrónico</p>
                                </div>
                                <div class="column">
                                    <p>Teléfono</p>
                                </div>
                                <div class="column is-2">
                                    <p>Perfil de usuario</p>
                                </div>
                            </div>
                        </div>

                        @if ($users->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay usuarios cargados</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Users list --}}
                        @foreach ($users as $user)
                        <a href="{{ route('users.view', ['id' => $user->id]) }}">
                            <div class="box p-1 mb-2 is-shadowless list-item">
                                <div class="columns is-vcentered">
                                    <div class="column is-2">
                                        <p class="is-clipped">{{ $user->first_name . ' ' . $user->last_name }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">
                                            @if ($user->organization_count() == 0)
                                                Sin organización
                                            @else
                                                {{ $user->organization()->business_name }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">{{ $user->email }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">
                                            @if ($user->phone_number)
                                            {{ $user->phone_number }}
                                            @else
                                                No registrado
                                            @endif
                                        </p>
                                    </div>
                                    <div class="column is-2">
                                        <p class="is-clipped">
                                            @switch(Auth::user()->access_level_in_organization(session('organization_id')))
                                                @case(1) Cliente @break
                                                @case(2) Administración @break
                                                @case(3) Facturación @break
                                                @case(4) Dueño @break
                                                @case(5) Mesa de ayuda @break
                                                @case(6) Administración @break
                                                @case(7) Facturación @break
                                                @case(8) Administrador @break
                                                @default Error
                                            @endswitch
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>   
@endsection