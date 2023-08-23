@extends('components.layouts.app')

@section('title')
    Iniciar sesión    
@endsection

@section('content')
<div class="hero is-fullheight has-background-light login-background">

    <div class="hero-body is-flex justify-content-center">

        <div class="container">

            <div class="columns is-centered is-vcentered">

                <div class="column is-one-third">

                    @if (session('status') != null)

                        <div class="columns is-centered is-vcentered">
                            <div class="column is-10">
                                <div class="notification is-success">
                                    <p class="has-text-centered">{{ session('status') }}</p>
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

                    <div class="box transparent-box">

                        <form action="" method="post">

                            @csrf

                            <div class="field pt-2">
                                <label class="label">Correo electrónico</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="credential" id="credential" placeholder="correo@midominio.com.ar / 12345678">
                                    <span class="icon is-small is-left">
                                        <i class="bx bx-user"></i>
                                    </span>
                                </div>
                            </div>

                            <label class="label">Contraseña</label>
                            <div class="field is-grouped">
                                <div class="field-body">
                                    <div class="field has-addons">
                                        <div class="control is-expanded has-icons-left">
                                            <input class="input" type="password" name="password" id="password" placeholder="***********">
                                            <span class="icon is-small is-left">
                                                <i class="bx bx-key"></i>
                                            </span>
                                        </div>
                                        <div class="control">
                                            <a class="button" id="toggle-password">
                                                <span class="icon is-small">
                                                    <i class="bx bx-show"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="field pt-0 mb-0 is-flex is-justify-content-flex-end">
                                <a href="">
                                    <p class="help">¿Olvidaste la contraseña?</p>
                                </a>
                            </div>

                            <div class="level-item has-text-centered">

                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <button type="submit" class="button is-link">Iniciar sesión</button>
                                    </div>
                                    <div class="control">
                                        <a href="{{ route('auth.register') }}"><button type="button" class="button is-link is-light">Registrarse</button></a>
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
    document.getElementById("toggle-password").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = this.querySelector("i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("show");
            eyeIcon.classList.add("hide");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("hide");
            eyeIcon.classList.add("show");
        }
    });
</script>
@endsection
