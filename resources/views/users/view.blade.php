@extends('users.index')

@section('users')
<div class="box has-background-light">
    <form action="#" method="post">
        @csrf
        <div class="field">
            <label class="label" for="first_name">Nombre/s</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="first_name" id="first_name" placeholder="Escriba aquí el nombre del usuario..." value="{{ $user->first_name }}">
                <span class="icon is-small is-left">
                    <i class="bx bxs-id-card"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class='bx bx-error-circle'></i>
                </span>
            </div>
            @if ($errors->edit->first('first_name'))
                <small style="color: red">{{ $errors->edit->first('first_name') }} </small>
            @endif
        </div>

        <div class="field">
            <label class="label" for="last_name">Apellido/s</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="last_name" id="last_name" placeholder="Escriba aquí el apellido del usuario..." value="{{ $user->last_name }}">
                <span class="icon is-small is-left">
                    <i class="bx bxs-id-card"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class='bx bx-error-circle'></i>
                </span>
            </div>
            @if ($errors->edit->first('last_name'))
                <small style="color: red">{{ $errors->edit->first('last_name') }} </small>
            @endif
        </div>

        <div class="field">
            <label class="label" for="phone_number">Teléfono de contacto</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="phone_number" id="phone_number" placeholder="Escriba aquí el teléfono del usuario..." value="{{ $user->phone_number }}">
                <span class="icon is-small is-left">
                    <i class="bx bx-phone"></i>
                </span>
            </div>
            @if ($errors->edit->first('phone_number'))
                <small style="color: red">{{ $errors->edit->first('phone_number') }} </small>
            @endif
        </div>

        <div class="field">
            <label class="label" for="email">Correo electrónico</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="email" name="email" id="email" placeholder="correo@midominio.com" value="{{ $user->email }}">
                <span class="icon is-small is-left">
                    <i class="bx bx-envelope"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class='bx bx-error-circle'></i>
                </span>
            </div>
            @if ($errors->edit->first('email'))
                <small style="color: red">{{ $errors->edit->first('email') }} </small>
            @endif
        </div>

        <div class="field">
            <label class="label" for="password">Contraseña</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="password" name="password" id="password" placeholder="***********" value="***********">
                <span class="icon is-small is-left">
                    <i class="bx bx-key"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class='bx bx-error-circle'></i>
                </span>
            </div>
            @if ($errors->edit->first('password'))
                <small style="color: red">{{ $errors->edit->first('password') }} </small>
            @endif        
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">Confirmar contraseña</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input" type="password" name="password_confirmation" id="password_confirmation" placeholder="***********" value="***********">
                <span class="icon is-small is-left">
                    <i class="bx bx-key"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class='bx bx-error-circle'></i>
                </span>
            </div>
            @if ($errors->edit->first('password_confirmation'))
                <small style="color: red">{{ $errors->edit->first('password_confirmation') }} </small>
            @endif
        </div>

        <div class="field">
            <label class="label" for="organization">Organización/es</label>
            <div class="columns">
                <div class="column is-11">
                    <div class="control has-icons-left has-icons-right">
                        <div class="select is-fullwidth">
                            <select name="organization" id="organization-dropdown">
                                @foreach ($user_organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->business_name }}</option>
                                @endforeach
                            </select>
                            <span class="icon is-small is-left">
                                <i class="bx bxs-business"></i>
                            </span>
                        </div>
                    </div>
                    @if ($errors->edit->first('organization'))
                        <small style="color: red">{{ $errors->edit->first('organization') }} </small>
                    @endif
                </div>
                <div class="column pl-0">
                    <a href="#" id="productive-unit-add-button">
                        <button class="button is-link" type="button">
                            <i class="bx bx-plus" ></i>
                        </button>
                    </a>
                </div>
            </div>
            
        </div>

        <div class="level-item has-text-centered">
            <div class="field is-grouped pt-3">
                <div class="control">
                    <a href="{{ route('users.delete', ['id' => $user->id]) }}">
                        <button type="button" class="button is-link is-danger">
                            <i class="bx bx-trash"></i>
                        </button>
                    </a>
                </div>
                <div class="control">
                    <button type="submit" class="button is-link">
                        <i class="bx bx-save"></i>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection