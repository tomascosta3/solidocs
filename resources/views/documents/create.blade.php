@extends('components.layouts.nav')

@section('title')
    Nuevo documento
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
                        <form action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
                            
                            @csrf

                            <div class="field">
                                <label class="label" for="name">Nombre del archivo</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="name" id="name" placeholder="Escriba aquí el nombre del archivo...">
                                    <span class="icon is-small is-left">
                                        <i class="bx bxs-id-card"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->register->first('name'))
                                    <small style="color: red">{{ $errors->register->first('name') }} </small>
                                @endif
                            </div>
                
                            <div class="field">
                                <label class="label" for="required_access_level">Sector</label>
                                <div class="control has-icons-left has-icons-right">
                                    <div class="select is-fullwidth">
                                        <select name="required_access_level" id="required_access_level">
                                            @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 3)
                                            <option value="3">Mesa de ayuda</option>
                                            @endif
                                            @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 4)
                                            <option value="4">Administración</option>
                                            @endif
                                            @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 5)
                                            <option value="5">Facturación</option>
                                            @endif
                                        </select>
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-business"></i>
                                        </span>
                                    </div>
                                </div>
                                @if (session('error_required_access_level'))
                                    <small style="color: red">{{ session('error_required_access_level') }} </small>
                                @endif
                            </div>

                            <div class="field">
                                <label class="label" for="comment">Comentario</label>
                                <div class="control">
                                    <textarea class="textarea" name="comment" placeholder="Ingrese un comentario..."></textarea>
                                </div>
                                @if (session('error_comment'))
                                    <small style="color: red">{{ session('error_comment') }} </small>
                                @endif
                            </div>
                
                            <div class="field">
                                <label class="label" for="document">Archivo</label>
                                <div class="file has-name is-fullwidth">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="file" id="inputFile">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="bx bx-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Seleccionar archivo…
                                            </span>
                                        </span>
                                        <span class="file-name">
                                            Cargue el archivo aquí...
                                        </span>
                                    </label>
                                </div>
                                @if (session('error_file'))
                                    <small style="color: red">{{ session('error_file') }} </small>
                                @endif
                            </div>

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('documents') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-link">Crear documento</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.file-input').change(function() {
            var filename = $(this).val().split('\\').pop();
            $('.file-name').text(filename);
        });
    });
</script>
@endsection