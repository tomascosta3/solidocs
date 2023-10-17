@extends('components.layouts.nav')

@section('title')
    Documentos
@endsection

@section('style')
<style>
    .file-explorer .menu-list a {
        display: flex;
        align-items: center;
    }

    .folder-content {
        display: none;
    }   

    .expand-indicator {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .folder-item {
        display: flex;
        align-items: center;
    }

    .expand-indicator, .folder-content-link {
        display: inline-block;
        vertical-align: middle;
    }

    .folder-box {
        display: flex !important;
        align-items: center !important;
        width: 100%;
        background: none !important;
        justify-content: space-between;
    }

    .folder-box:hover {
        background-color: var(--dark-mode-primary-color) !important;
        color: var(--dark-mode-text-color);
    }

    .folder-box:hover a{
        color: var(--dark-mode-text-color);
    }

    .folder-selected {
        background-color: var(--dark-mode-primary-color) !important;
        color: var(--dark-mode-text-color) !important;
    }

    .folder-selected a{
        color: var(--dark-mode-text-color) !important;
    }

    .left-content {
        display: flex;
    }

    .menu-label {
        color: var(--dark-mode-sidebar-color);
    }

    .hero {
        height: var(--main-content-height); /* Asegura que el hero ocupe todo el alto de la ventana del navegador */
        display: flex; /* Hace que el hero sea un contenedor flex */
        flex-direction: column; /* Asegura que los hijos directos de .hero (es decir, .hero-body) se apilen verticalmente */
    }

    .hero-body {
        flex-grow: 1; /* Hace que .hero-body ocupe todo el espacio disponible dentro de .hero */
        display: flex; /* Hace que .hero-body sea un contenedor flex */
        justify-content: center; /* Centra el contenido de .hero-body horizontalmente */
        max-height: 100%;
    }

    .max-height-available {
        height: 100%;
        max-height: 100%;
    }

    .scrollable {
        overflow-y: auto;
    }

    .no-border {
        border: none !important;
        border-radius: 0 !important;
    }

    .menu-list li a:hover {
        background: none;
        width: 100%
    }

    /* Options */
    .options-wrap {
        position: absolute;
        width: 180px;
        max-height: 0px;
        overflow: hidden;
        background: var(--dark-mode-sidebar-color);
        border-radius: 10px;
    }

    .options-wrap.open-options {
        max-height: 300px;
    }

    .option-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        margin: 0px;
    }

    .option-link p {
        width: 100%;
        color: var(--dark-mode-text-color);
    }

    .option-link:hover p {
        font-weight: 600;
    }

    .option-link span {
        transition: transform 0.5s;
        color: var(--dark-mode-text-color);
    }

    .option-link:hover span {
        transform: translateX(5px);
    }

</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">
            <div class="file-explorer max-height-available">
                <div class="columns max-height-available">
                    <div class="column is-3">
                        <!-- Panel lateral para carpetas -->
                        <div class="box secondary-background max-height-available">
                            <aside class="menu">
                                <p class="menu-label">Explorador de Archivos</p>
                                <div class="scrollable no-border m-0 p-0">
                                    <ul class="menu-list">
                                        @foreach($folders as $folder)
                                            @if (!$folder->parent)
                                                @include('documents.folders', ['folder' => $folder, 'level' => 0])
                                            @endif
                                        @endforeach
                                    </ul>                            
                                </div>
                            </aside>
                        </div>
                    </div>
                    <div class="column is-9">
                        <!-- Área principal para mostrar el contenido de la carpeta actual -->
                        <div class="box max-height-available">
                            <h1 class="title">Carpeta 1</h1>
                            <div>
                                <!-- Aquí irían los archivos de la carpeta actual -->
                                <p>Archivo 1.1</p>
                            </div>
                        </div>
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

        $(document).ready(function() {
            $('.expand-indicator').click(function(e) {
                e.preventDefault();

                var target = $(this).data('target');

                if ($('#' + target).is(':visible')) {
                    $(this).removeClass('bx-chevron-down').addClass('bx-chevron-right');
                } else {
                    $(this).removeClass('bx-chevron-right').addClass('bx-chevron-down');
                }

                $('#' + target).toggle();
            });

            // Muestra el contenido de la carpeta con el enlace
            $('.folder-content-link').click(function(e) {
                e.preventDefault();

                var folderId = $(this).data('folder-id');

                // Aquí es donde puedes agregar la lógica para mostrar el contenido de la carpeta
                // en el lado derecho. Dependerá de cómo tengas estructurada tu aplicación y de
                // dónde esté almacenada la información sobre los archivos y subcarpetas de cada carpeta.
                // Puede que necesites hacer una solicitud AJAX para obtener este contenido, o quizás 
                // sólo necesites mostrar/ocultar un div que ya contenga la información.

                // Ejemplo simple (puedes adaptarlo según tus necesidades):
                $('.folder-content-display').hide();  // Oculta todos los contenidos
                $('#folder-content-' + folderId).show();  // Muestra el contenido específico de la carpeta clickeada
            });

            $('.folder-box').on('click', function() {
                // Eliminar la clase 'folder-selected' de todas las carpetas
                $('.folder-box').removeClass('folder-selected');
                
                // Añadir la clase 'folder-selected' a la carpeta clickeada
                $(this).addClass('folder-selected');
            });

            $('.folder-option-button').on('click', function(e) {
                e.stopPropagation();

                var associatedMenu = $(this).next('.options-wrap');

                var position = $(this).position();
                var topPosition = position.top;
                var leftPosition = position.left + $(this).outerWidth();

                associatedMenu.css({
                    'top': topPosition + 'px',
                    'left': leftPosition + 'px'
                });

                var wasOpen = associatedMenu.hasClass('open-options');

                // Cierra todos los menús
                $('.options-wrap').removeClass('open-options');

                // Si el menú no estaba abierto originalmente, ábrelo.
                if (!wasOpen) {
                    associatedMenu.addClass('open-options');
                }
            });

            $(document).on('click', function() {
                $('.options-wrap').removeClass('open-options');
            });

            $('.options-wrap').on('click', function(e) {
                e.stopPropagation();
            });
        });


    </script>
@endsection

@section('main-content-old')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">
                
                <div class="column is-8">
                    <div class="box secondary-background">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-3">
                                    <strong>
                                        Documentos
                                    </strong>
                                </p>
                            </div>
                        </div>

                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3">
                            <form action="{{ route('documents') }}" method="get">
                                <div class="columns is-vcentered is-centered">
                                    <div class="column is-10">
                                        <div class="field has-addons">
                                            <div class="control has-icons-left is-expanded">
                                                <input class="input" type="text" name="search" placeholder="Buscar por el nombre del archivo..." value="{{ session('filter') }}">
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
                                        <a href="{{ route('documents.create') }}">
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

                        <div class="box p-2 mb-2 has-background-grey-lighter is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column is-6">
                                    <p>Nombre</p>
                                </div>
                                <div class="column is-2">
                                    <p class="has-text-centered">Tipo</p>
                                </div>
                                <div class="column is-4">
                                    <p class="has-text-centered">Fecha de modificación</p>
                                </div>
                            </div>
                        </div>

                        @if ($documents->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay documentos cargados</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Documents list --}}
                        @foreach ($documents as $document)
                        <a href="{{ route('documents.view', ['id' => $document->id ]) }}">
                            <div class="box p-1 mb-2 has-background-white is-shadowless">
                                <div class="columns is-vcentered">
                                    <div class="column is-6">
                                        <p>{{ $document->name }}</p>
                                    </div>
                                    <div class="column is-2">
                                        <p class="has-text-centered">
                                            @if (in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['jpg', 'png']))
                                                Imagen
                                            @else
                                                @if (in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['pdf']))
                                                    PDF
                                                @else
                                                    Word
                                                @endif
                                            @endif    
                                        </p>
                                    </div>
                                    <div class="column is-4">
                                        <p class="has-text-centered">{{ $document->formatted_update_date() }}</p>
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