@extends('users.index')

@section('users')

{{-- Organizations list modal --}}
<div class="modal" id="organizations-modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <h3 class="title is-3 has-text-centered">Organizaciones a vincular</h3>
        </header>
        <section class="modal-card-body">
            <label class="label has-text-centered is-size-4">Seleccioná la organización</label>
            <div class="scrollable">
                @foreach ($organizations as $organization)
                <a href="#" class="organization-link" id="trigger-modal-link" data-id="{{ $organization->id }}">
                    <div class="box is-shadowless has-background-light p-2 mb-2">
                        <p>{{ $organization->business_name }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        <footer class="modal-card-foot py-0">
            <div class="column">
                <button class="button" type="button" id="organizations-cancel-button">Cancelar</button>
            </div>
            <div class="column">
                <button class="button is-primary is-pulled-right" type="submit" id="expiration-save-button">Guardar</button>
            </div>
        </footer>
    </div>
</div>


{{-- Add organization modal --}}
<div class="modal" id="confirmation-modal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Confirmación</p>
            <button class="delete" aria-label="close" id="close-modal-button"></button>
        </header>
        <section class="modal-card-body">
            ¿Estás seguro de realizar esta acción?
        </section>
        <footer class="modal-card-foot">
            <button class="button" id="cancel-button">Cancelar</button>
            <button class="button is-success" id="confirm-button">Confirmar</button>
        </footer>
    </div>
</div>

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
                                    <option value="{{ $organization->id }}" data-access-level="{{ $organization->pivot->access_level }}">{{ $organization->business_name }}</option>
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
                        <button class="button is-link" type="button" id="add-organization-button">
                            <i class="bx bx-plus" ></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="access_level">Nivel de acceso</label>
            <div class="columns">
                <div class="column is-10">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="access_level" id="access_level" readonly>
                        <span class="icon is-small is-left">
                            <i class="bx bx-key"></i>
                        </span>
                    </div>
                    @if ($errors->create->first('access_level'))
                        <small style="color: red">{{ $errors->create->first('access_level') }} </small>
                    @endif
                </div>
                <div class="column">
                    <a href="#">
                        <button class="button is-link" type="button">
                            Cambiar
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

@section('scripts')

@parent

<script>  

    // Organizations modal options.

    // Show modal when user click on add organization button.
    const addOrganizationButton = document.getElementById("add-organization-button");

    addOrganizationButton.addEventListener("click", function() {

        const modal = document.getElementById("organizations-modal");

        modal.style.display = "flex";
    });

    // Close modal when user click on cancel button.
    const organizationsCancelButton = document.getElementById("organizations-cancel-button");

    organizationsCancelButton.addEventListener("click", function() {

        const modal = document.getElementById("organizations-modal");

        modal.style.display = "none";
    })

    // Change access level input value based on user's organization.
    function setAccessLevel() {
        let dropdown = document.getElementById('organization-dropdown');
        let selectedOption = dropdown.options[dropdown.selectedIndex];
        let accessLevel = selectedOption.getAttribute('data-access-level');

        if(accessLevel == 1) { accessLevel = 'Cliente'; }
        else if(accessLevel == 2) { accessLevel = 'Administración'; }
        else if(accessLevel == 3) { accessLevel = 'Facturación'; }
        else if(accessLevel == 4) { accessLevel = 'Dueño'; }
        else if(accessLevel == 5) { accessLevel = 'Mesa de ayuda'; }
        else if(accessLevel == 6) { accessLevel = 'Administración'; }
        else if(accessLevel == 7) { accessLevel = 'Facturación'; }
        else if(accessLevel == 8) { accessLevel = 'Administrador'; }

        document.getElementById('access_level').value = accessLevel;
    }

    // Add the event to the dropdown so that changing the value updates the access level.
    document.getElementById('organization-dropdown').addEventListener('change', setAccessLevel);

    // Call the function to set the access level on page load.
    setAccessLevel();

    /**
     * Confirm organization modal.
     */
    document.addEventListener('DOMContentLoaded', function() {
    const organizationLinks = document.querySelectorAll('.organization-link');
    console.log(organizationLinks);
    const modal = document.getElementById('confirmation-modal');
    const closeModalButton = document.getElementById('close-modal-button');
    const modalOrgName = document.getElementById('modal-org-name');

    // Función para mostrar el modal
    function showModal() {
        modal.classList.add('is-active');
    }

    // Función para ocultar el modal
    function closeModal() {
        modal.classList.remove('is-active');
    }

    // Adjuntamos el eventListener a cada enlace de organización
    organizationLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            console.log("Enlace de organización clickeado!"); // <-- Añadir esto
            // ... resto del código ...
        });

        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Obtener el nombre de la organización del contenido del enlace
            const orgName = event.currentTarget.querySelector('p').textContent.trim();

            // Mostrar los datos en el modal
            modalOrgName.textContent = orgName;

            // Mostrar el modal
            showModal();
        });
    });

    // Evento para cerrar el modal
    closeModalButton.addEventListener('click', closeModal);

    // Si tienes otros botones o acciones en el modal, asegúrate de que también tengan su lógica aquí
    });

</script>
@endsection