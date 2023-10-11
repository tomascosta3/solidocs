<li class="subfolder-level-{{ $level }}">
    @if(count($folder->subfolders) > 0)
        <span class="expand-indicator">→</span>
    @endif
    <a href="#" class="expandable-folder" data-target="folder-content-{{ $folder->id }}">
        {{ $folder->name }}
    </a>
    @if(count($folder->subfolders) > 0)
        <ul id="folder-content-{{ $folder->id }}" class="folder-content">
            @foreach($folder->subfolders as $subfolder)
                @include('documents.folders', ['folder' => $subfolder, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
