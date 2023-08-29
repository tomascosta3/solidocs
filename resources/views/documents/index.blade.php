@extends('components.layouts.nav')

@section('title')
    Documentos
@endsection

@section('main-content')
<div class="hero is-fullheight">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                <div class="column is-6 full-height">
                    <div class="box has-background-light">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-4">
                                    Documentos
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3">
                            <form action="#" method="post">
                                <div class="columns is-vcentered is-centered">
                                    <div class="column is-10">
                                        <div class="field has-addons">
                                            <div class="control has-icons-left is-expanded">
                                                <input class="input" type="text" name="filter" placeholder="Buscar por el nombre del archivo..." value="{{ session('filter') }}">
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


                {{-- Error or success message with document view --}}
                <div class="column is-8 full-height">    
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

                    @yield('document')
                </div>

            </div>

        </div>
    </div>
</div>
@endsection