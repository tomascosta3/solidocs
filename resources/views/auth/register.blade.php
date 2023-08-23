@extends('components.layouts.app')

@section('title')
    Registrarse
@endsection

@section('content')

    <div class="hero is-fullheight has-background-light">

        <div class="hero-body is-flex justify-content-center">

            <div class="container">

                <div class="columns is-centered is-vcentered">

                    <div class="column is-one-third">

                        <div class="box">

                            <form action="{{ route('auth.register.user') }}" method="post">

                                @csrf
    
                                <div class="field">
                                    <label class="label" for="first_name">Nombre/s</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="text" name="first_name" id="first_name" placeholder="Escriba aquí el/los nombres...">
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-id-card"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('first_name'))
                                        <small style="color: red">{{ $errors->register->first('first_name') }} </small>
                                    @endif
                                </div>
    
                                <div class="field">
                                    <label class="label" for="last_name">Apellido/s</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="text" name="last_name" id="last_name" placeholder="Escriba aquí el/los apellido...">
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-id-card"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('last_name'))
                                        <small style="color: red">{{ $errors->register->first('last_name') }} </small>
                                    @endif
                                </div>

                                <div class="field">
                                    <label class="label" for="dni">DNI</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="text" name="dni" id="dni" placeholder="Ingrese aquí el dni (sin puntos)">
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-id-card"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('dni'))
                                        <small style="color: red">{{ $errors->register->first('dni') }} </small>
                                    @endif
                                </div>

                                <div class="field">
                                    <label class="label" for="phone_number">Teléfono de contacto</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" name="phone_number" id="phone_number" placeholder="xx xxxx-xxxxxx">
                                        <span class="icon is-small is-left">
                                            <i class="bx bx-phone"></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('phone_number'))
                                        <small style="color: red">{{ $errors->register->first('phone_number') }} </small>
                                    @endif
                                </div>
    
                                <div class="field">
                                    <label class="label" for="email">Correo electrónico</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="email" name="email" id="email" placeholder="correo@midominio.com">
                                        <span class="icon is-small is-left">
                                            <i class="bx bx-envelope"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('email'))
                                        <small style="color: red">{{ $errors->register->first('email') }} </small>
                                    @endif
    
                                </div>
    
                                <div class="field">
                                    <label class="label" for="password">Contraseña</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="password" name="password" id="password" placeholder="***********">
                                        <span class="icon is-small is-left">
                                            <i class="bx bx-key"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('password'))
                                        <small style="color: red">{{ $errors->register->first('password') }} </small>
                                    @endif        
                                </div>
    
                                <div class="field">
                                    <label class="label" for="password_confirmation">Confirmar contraseña</label>
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input" type="password" name="password_confirmation" id="password_confirmation" placeholder="***********">
                                        <span class="icon is-small is-left">
                                            <i class="bx bx-key"></i>
                                        </span>
                                        <span class="icon is-small is-right">
                                            <i class='bx bx-error-circle'></i>
                                        </span>
                                    </div>
    
                                    @if ($errors->register->first('password_confirmation'))
                                        <small style="color: red">{{ $errors->register->first('password_confirmation') }} </small>
                                    @endif
                                </div>
    
                                <div class="level-item has-text-centered">
                                    <div class="field is-grouped pt-3">
                                        <div class="control">
                                            <button type="submit" class="button is-link">Registrarse</button>
                                        </div>
                                        <div class="control">
                                            <a href="{{ route('auth.login') }}"><button type="button" class="button is-link is-light">Cancelar</button></a>
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