@extends('components.layouts.nav')

@section('title')
    Grupos
@endsection

@section('main-content')

{{-- Add user to group modal --}}
<div class="modal" id="userModal">
    <form action="{{ route('users.groups.add-users', ['group_id' => $group->id]) }}" method="post" id="add-users-form">
        @csrf
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Agregar usuarios al grupo</p>
                <button class="delete" type="button" id="closeModal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div>
                    <div class="columns">
                        <div class="column">
                            @foreach($first_column_users as $user)
                            <div class="is-flex is-align-items-center mb-3">
                                <label class="checkbox mr-2"><input type="checkbox" class="mr-2" name="users[]" value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</label>
                                <div class="select is-small">
                                    <select name="roles[{{ $user->id }}]" id="" class="select-role" required>
                                        @if ($user->access_level_in_organization(session('organization_id')) < 8)
                                        <option value="viewer">Viewer</option>
                                        <option value="editor">Editor</option>
                                        <option value="admin">Admin</option>
                                        @else
                                        <option value="creator">Creator</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    
                        <div class="column">
                            @foreach($second_column_users as $user)
                            <div class="is-flex is-align-items-center mb-3">
                                <label class="checkbox mr-2"><input type="checkbox" class="mr-2" name="users[]" value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</label>
                                <div class="select is-small">
                                    <select name="roles[{{ $user->id }}]" id="" class="select-role" required>
                                        @if ($user->access_level_in_organization(session('organization_id')) < 8)
                                        <option value="viewer">Viewer</option>
                                        <option value="editor">Editor</option>
                                        <option value="admin">Admin</option>
                                        @else
                                        <option value="creator">Creator</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($first_column_users->isEmpty() && $second_column_users->isEmpty())
                        No hay usuarios disponibles para agregar al grupo
                    @endif
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-success" type="submit">Agregar Seleccionados</button>
                <button class="button" id="cancelModal" type="button">Cancelar</button>
            </footer>
        </div>
    </form>
</div>


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
                        <form action="{{ route('users.groups.edit', ['group_id' => $group->id]) }}" method="post">
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
                                                <p>Rol dentro del grupo</p>
                                            </div>
                                            <div class="column is-1 is-flex is-justify-content-center is-align-items-center">
                                                <button class="button add-button" id="openModal" type="button">
                                                    <i class="bx bxs-user-plus"></i>
                                                </button>
                                            </div>
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
                                    <div class="box py-1 px-2 mb-2 is-shadowless list-item">
                                        <div class="columns is-vcentered is-2">
                                            <div class="column is-3">
                                                <p class="is-clipped">{{ $user->first_name . ' ' . $user->last_name }}</p>
                                            </div>
                                            <div class="column">
                                                <p class="is-clipped">{{ $user->email }}</p>
                                            </div>
                                            <div class="column is-3">
                                                <p class="is-clipped">
                                                    @switch($user->groups->where('id', $group->id)->first()->pivot->role)
                                                        @case('viewer') Viewer @break
                                                        @case('editor') Editor @break
                                                        @case('admin') Admin @break
                                                        @case('creator') Creador @break
                                                        @default Error
                                                    @endswitch
                                                </p>
                                            </div>
                                            <div class="column is-1 is-flex is-justify-content-center is-align-items-center">
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
                                        <a href="{{ route('users.groups.delete', ['group_id' => $group->id]) }}">
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

@section('scripts')
    @parent

    <script>
        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('userModal').classList.add('is-active');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('userModal').classList.remove('is-active');
            document.getElementById('add-users-form').reset()
        });

        document.getElementById('cancelModal').addEventListener('click', function() {
            document.getElementById('userModal').classList.remove('is-active');
            document.getElementById('add-users-form').reset()
        });
    </script>
@endsection