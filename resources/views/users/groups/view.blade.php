@extends('components.layouts.nav')

@section('title')
    Grupos
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                {{-- Error or success message with document view --}}
                <div class="column is-8">    
                    @if (session('success') != null)
                        <div class="columns is-centered is-vcentered">
                            <div class="column is-10">
                                <div class="notification is-success">
                                    <p class="has-text-centered">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('problem') != null)
                        <div class="columns is-centered is-vcentered">
                            <div class="column is-11">
                                <div class="notification is-danger">
                                    <p class="has-text-centered">{{ session('problem') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="box secondary-background">
                        <form action="#" method="post">
                            @csrf
                            <div class="field">
                                <label class="label" for="name">Nombre del grupo</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="name" id="name" placeholder="Escriba aquí el nombre del grupo..." value="{{ $group->name }}">
                                    <span class="icon is-small is-left">
                                        <i class="bx bxs-id-card"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->edit->first('name'))
                                    <small style="color: red">{{ $errors->edit->first('name') }} </small>
                                @endif
                            </div>

                            <div class="box is-shadowless">
                                <div class="field">
                                    <label class="label has-text-centered is-size-4" for="group-users">Usuarios del grupo</label>
                                    <div class="box p-2 mb-2 is-shadowless categories">
                                        <div class="columns is-vcentered is-2">
                                            <div class="column is-3">
                                                <p>Nombre</p>
                                            </div>
                                            <div class="column">
                                                <p>Correo electrónico</p>
                                            </div>
                                            <div class="column is-3">
                                                <p>Perfil de usuario</p>
                                            </div>
                                            <div class="column is-1"></div>
                                        </div>
                                    </div>
            
                                    @if ($group_users->isEmpty())
                                    <div class="box p-1 has-background-white is-shadowless">
                                        <div class="columns is-vcentered">
                                            <div class="column">
                                                <p class="has-text-centered">No hay usuarios cargados al grupo</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                        
                                    {{-- Group users list --}}
                                    @foreach ($group_users as $user)
                                    <div class="box p-1 mb-2 is-shadowless list-item">
                                        <div class="columns is-vcentered is-2">
                                            <div class="column is-3">
                                                <p class="is-clipped">{{ $user->first_name . ' ' . $user->last_name }}</p>
                                            </div>
                                            <div class="column">
                                                <p class="is-clipped">{{ $user->email }}</p>
                                            </div>
                                            <div class="column is-3">
                                                <p class="is-clipped">
                                                    @switch($user->access_level_in_organization(session('organization_id')))
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
                                            <div class="column is-1">
                                                <a href="{{ route('users.groups.remove-user', ['group_id' => $group->id, 'user_id' => $user->id]) }}" onclick="return confirm('¿Estás seguro de desvincular a este usuario?');">
                                                    <i class="bx bx-x is-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                
                                    @endforeach
                                </div>
                            </div>
    
                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('users.groups') }}">
                                            <button type="button" class="button is-link">
                                                <i class="bx bx-left-arrow-alt"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <a href="#">
                                            <button type="button" class="button is-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-success">
                                            <i class="bx bx-save"></i>
                                        </button>
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