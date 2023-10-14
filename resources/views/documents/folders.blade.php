<li class="subfolder-level-{{ $level }}">
    <div class="folder-item">
        @if(count($folder->subfolders) > 0)
            <i class="expand-indicator bx bx-chevron-right" data-target="folder-content-{{ $folder->id }}"></i>
        @endif
        <a href="#" class="expandable-folder-link" data-folder-id="{{ $folder->id }}">
            {{ $folder->name }}
        </a>
    </div>
    @if(count($folder->subfolders) > 0)
        <ul id="folder-content-{{ $folder->id }}" class="folder-content my-0">
            @foreach($folder->subfolders as $subfolder)
                @include('documents.folders', ['folder' => $subfolder, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
