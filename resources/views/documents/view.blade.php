@extends('documents.index')

@section('document')
    @if ($document->path && in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['jpg', 'png']))
        <img src="{{ URL::asset($document->path) }}" alt="Document image">
    @else 
    @if ($document->path && in_array(pathinfo($document->path, PATHINFO_EXTENSION), ['pdf']))
        <iframe src="{{ URL::asset('/uploads/'.$document->path) }}" frameborder="0" width="800em" height="800vh"></iframe>
    @endif
@endif
@endsection