@extends('documents.index')

@section('document')

{{-- Show document --}}
@if (isset($document->path) && in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['jpg', 'png']))
    <div class="has-text-centered is-flex is-align-items-center is-justify-content-center">
        <img class="mb-6" src="{{ URL::asset($document->path) }}" alt="Document image" style="max-height: 55vh">
    </div>
@else 
    @if (isset($document->path) && in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['pdf']))
        <iframe class="mb-6" src="{{ URL::asset($document->path) }}" frameborder="0" style="height: 55vh; width: 46vw"></iframe>
    @endif

    @if (isset($document->path) && in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['docx']))
    <div class="box has-background-light" style="max-height: 30vh">
        <p class="has-text-centered is-size-4">Contenido no se puede visualizar</p>
    </div>
    @endif
@endif

{{-- Document details. --}}
<div class="box has-background-light" style="max-height: 30vh">
    <form action="{{ route('documents.edit', ['id' => $document->id]) }}" method="post">
        @csrf
        <div class="columns is-vcentered is-centered mb-0">
            <div class="column">
                <div class="field">
                    <label class="label" for="name">Nombre del archivo</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="name" id="name" placeholder="Escriba aquí el nombre del archivo..." value="{{ $document->name }}">
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
                                    <option value="3"
                                    @if ($document->required_access_level == 3)
                                        selected
                                    @endif
                                    >Mesa de ayuda</option>
                                    @endif
                                    @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 4)
                                    <option value="4"
                                    @if ($document->required_access_level == 4)
                                        selected
                                    @endif
                                    >Administración</option>
                                    @endif
                                    @if (Auth::user()->access_level_in_organization(session('organization_id')) >= 5)
                                    <option value="5"
                                    @if ($document->required_access_level == 5)
                                        selected
                                    @endif
                                    >Facturación</option>
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
            </div>
            <div class="column">
                <div class="field">
                    <label class="label" for="comment">Comentario</label>
                    <div class="control">
                        <textarea class="textarea" name="comment" placeholder="Ingrese un comentario...">{{ $document->comment }}</textarea>
                    </div>
                    @if (session('error_comment'))
                        <small style="color: red">{{ session('error_comment') }} </small>
                    @endif
                    <p class="help">No es obligatorio</p>
                </div>
            </div>
        </div>

        <div class="level-item has-text-centered">
            <div class="field is-grouped pt-3">
                <div class="control">
                    <a href="{{ route('documents.delete', ['id' => $document->id]) }}">
                        <button type="button" class="button is-link is-danger">
                            <i class="bx bx-trash"></i>
                        </button>
                    </a>
                </div>
                <div class="control">
                    <a href="{{ route('documents.download', ['id' => $document->id]) }}">
                        <button type="button" class="button is-link is-success">
                            <i class="bx bxs-download"></i>
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