@extends('components.layouts.nav')

@section('title')
    Inicio
@endsection

@section('main-content')

<div class="hero is-fullheight is-light">
    <div class="hero-body">
        <div class="container">
                
            <div class="section">
                <div class="columns is-vcentered">
                    <div class="column has-text-centered is-offset-1 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-folder-open"></i>
                                <br>
                                <p>Documentos</p>
                            </div>
                        </a>
                    </div>
                    <div class="column has-text-centered is-offset-2 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-book-content"></i>
                                <br>
                                <p>Dailys</p>
                            </div>
                        </a>
                    </div>
                    <div class="column has-text-centered is-offset-2 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-buildings"></i>
                                <br>
                                <p>Organizaciones</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="columns is-vcentered">
                    <div class="column has-text-centered is-offset-1 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-group"></i>
                                <br>
                                <p>Usuarios</p>
                            </div>
                        </a>
                    </div>
                    <div class="column has-text-centered is-offset-2 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-wallet"></i>
                                <br>
                                <p>Facturación</p>
                            </div>
                        </a>
                    </div>
                    <div class="column has-text-centered is-offset-2 is-2">
                        <a href="">
                            <div class="box has-text-centered">
                                <i class="icon is-large is-size-1 bx bx-chat"></i>
                                <br>
                                <p>Consultas</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
    
@endsection