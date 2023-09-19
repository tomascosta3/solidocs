@extends('components.layouts.nav')

@section('title')
    Grupos
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                <div class="column is-7">
                    <div class="box secondary-background">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-3">
                                    <strong>
                                        Grupos de usuarios
                                    </strong>
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3 search">
                            <form action="#" method="get">
                                <div class="columns is-vcentered is-centered">
                                    <div class="column is-1">
                                        <a href="{{ route('users') }}">
                                            <button class="button is-link is-pulled-right" type="button">
                                                <span class="icon">
                                                    <i class="bx bx-left-arrow-alt"></i>
                                                </span>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="column is-9">
                                        <div class="field has-addons">
                                            <div class="control has-icons-left is-expanded">
                                                <input class="input" type="text" name="search" placeholder="Buscar por nombre..." value="{{ session('filter') }}">
                                                <span class="icon is-small is-left">
                                                    <i class="bx bx-search"></i>
                                                </span>
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
                                        <a href="{{ route('users.groups.create') }}">
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
                                <div class="column is-8">
                                    <p>Nombre</p>
                                </div>
                                <div class="column">
                                    <p class="has-text-centered">Cantidad de usuarios</p>
                                </div>
                            </div>
                        </div>

                        @if ($groups->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay grupos de usuarios cargados</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Groups list --}}
                        @foreach ($groups as $group)
                        <a href="#">
                            <div class="box p-1 mb-2 is-shadowless list-item">
                                <div class="columns is-vcentered">
                                    <div class="column is-8">
                                        <p class="is-clipped">{{ $group->name }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="has-text-centered is-clipped">{{ $group->users_count() }}</p>
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