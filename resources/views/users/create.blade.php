@extends('components.layouts.nav')

@section('title')
    Nuevo usuario
@endsection

@section('main-content')
<div class="hero is-fullheight">
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
                <div class="column is-5">
                    <div class="box">
                        <form action="{{ route('users.save') }}" method="post">
                            @csrf
                            <div class="field">
                                <label class="label" for="first_name">Nombre</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="first_name" id="first_name" placeholder="Escriba aquí el nombre del usuario...">
                                    <span class="icon is-small is-left">
                                        <i class="bx bxs-id-card"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->create->first('first_name'))
                                    <small style="color: red">{{ $errors->create->first('first_name') }} </small>
                                @endif
                            </div>

                            <div class="field">
                                <label class="label" for="last_name">Apellido</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="last_name" id="last_name" placeholder="Escriba aquí el apellido del usuario...">
                                    <span class="icon is-small is-left">
                                        <i class="bx bxs-id-card"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->create->first('last_name'))
                                    <small style="color: red">{{ $errors->create->first('last_name') }} </small>
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

                                @if ($errors->create->first('phone_number'))
                                    <small style="color: red">{{ $errors->create->first('phone_number') }} </small>
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
                                @if ($errors->create->first('email'))
                                    <small style="color: red">{{ $errors->create->first('email') }} </small>
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
                                @if ($errors->create->first('password'))
                                    <small style="color: red">{{ $errors->create->first('password') }} </small>
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

                                @if ($errors->create->first('password_confirmation'))
                                    <small style="color: red">{{ $errors->create->first('password_confirmation') }} </small>
                                @endif
                            </div>

                            <div class="field">
                                <label class="label" for="organization">Organización</label>
                                <div class="control has-icons-left has-icons-right">
                                    <div class="select is-fullwidth">
                                        <select name="organization" id="organization-dropdown">
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}">{{ $organization->business_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-business"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->create->first('organization'))
                                    <small style="color: red">{{ $errors->create->first('organization') }} </small>
                                @endif
                            </div>                     
                
                            <div class="field">
                                <label class="label" for="access_level">Nivel de acceso</label>
                                <div class="control has-icons-left has-icons-right">
                                    <div class="select is-fullwidth">
                                        <select name="access_level" id="access-level-dropdown">
                                            <option value="1">Cliente</option>
                                            <option value="2">Administración</option>
                                            <option value="3">Facturación</option>
                                            <option value="4">Dueño</option>
                                        </select>
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-business"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->create->first('access_level'))
                                    <small style="color: red">{{ $errors->create->first('access_level') }} </small>
                                @endif
                            </div>

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('users') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-link">Crear usuario</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const organizationDropdown = document.getElementById('organization-dropdown');
        const accessLevelDropdown = document.getElementById('access-level-dropdown');

        organizationDropdown.addEventListener('change', function() {
            // Cleaned up the current access level dropdown options.
            while (accessLevelDropdown.firstChild) {
                accessLevelDropdown.removeChild(accessLevelDropdown.firstChild);
            }

            // If the selected organization value (id) is 1 (Solido Connecting Solutions),
            //  we show different options.
            if (this.value === '1') {
                const options = [
                    { value: '5', text: 'Mesa de ayuda' },
                    { value: '6', text: 'Administración' },
                    { value: '7', text: 'Facturación' },
                    { value: '8', text: 'Administrador' },
                ];

                options.forEach(optionData => {
                    const optionElement = document.createElement('option');
                    optionElement.value = optionData.value;
                    optionElement.textContent = optionData.text;
                    accessLevelDropdown.appendChild(optionElement);
                });
            } else {
                
                const options = [
                    { value: '1', text: 'Cliente' },
                    { value: '2', text: 'Administración' },
                    { value: '3', text: 'Facturación' },
                    { value: '4', text: 'Dueño' },
                ];

                options.forEach(optionData => {
                    const optionElement = document.createElement('option');
                    optionElement.value = optionData.value;
                    optionElement.textContent = optionData.text;
                    accessLevelDropdown.appendChild(optionElement);
                });
            }
        });
    });
</script>
@endsection