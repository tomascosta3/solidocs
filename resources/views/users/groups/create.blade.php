@extends('components.layouts.nav')

@section('title')
    Nuevo grupo
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">
            
            @if (session('success') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-success">
                        <p class="has-text-centered">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('problem') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-danger">
                        <p class="has-text-centered">{{ session('problem') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="columns is-centered is-vcentered">
                <div class="column is-6">
                    <div class="box secondary-background">
                        <form action="{{ route('users.groups.stores') }}" method="post">
                            @csrf
                            <div class="field">
                                <label class="label" for="name">Nombre del grupo</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="name" id="name" placeholder="Escriba aquí el nombre del grupo...">
                                    <span class="icon is-small is-left">
                                        <i class="bx bxs-id-card"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->create->first('name'))
                                    <small style="color: red">{{ $errors->create->first('name') }} </small>
                                @endif
                            </div>  

                            <div class="columns is-vcentered">
                                <div class="column is-narrow">
                                    <label class="label">Color del grupo / eventos del calendario:</label>
                                </div>
                                <div class="column is-3">
                                    <div class="control">
                                        <input class="input" type="color" name="color" value="#FFFFFF">
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Selecciona usuarios</label>
                                <div class="columns">
                                    <div class="column">
                                        @foreach($firstColumnUsers as $user)
                                        <div class="is-flex is-align-items-center mb-3">
                                            <div class="box py-2 px-3 is-shadowless is-flex is-align-items-center">
                                                <input class="mr-2" type="checkbox" name="users[]" value="{{ $user->id }}">
                                                <span class="mr-2">{{ $user->first_name . ' ' . $user->last_name }}</span>
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
                                            
                                        </div>
                                        @endforeach
                                    </div>
                                
                                    <div class="column">
                                        @foreach($secondColumnUsers as $user)
                                        <div class="is-flex is-align-items-center mb-3">
                                            <div class="box py-2 px-3 is-shadowless is-flex is-align-items-center">
                                                <input class="mr-2" type="checkbox" name="users[]" value="{{ $user->id }}">
                                                <span class="mr-2">{{ $user->first_name . ' ' . $user->last_name }}</span>
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
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            

                            

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('users.groups') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-link">Crear grupo</button>
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