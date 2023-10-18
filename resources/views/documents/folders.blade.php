<li class="subfolder-level-{{ $level }}">
    <div class="folder-item">
        <div class="box folder-box px-0 py-1 mb-1 is-shadowless">
            <div class="left-content">
                @if(count($folder->subfolders) > 0)
                    <i class="expand-indicator bx bx-chevron-right pl-2" data-target="folder-content-{{ $folder->id }}"></i>
                @endif
                <a href="#" class="expandable-folder-link pl-2 py-0" data-folder-id="{{ $folder->id }}">
                    {{ $folder->name }}
                </a>
            </div>
            <i class="bx bx-dots-horizontal-rounded folder-option-button pr-3" data-folder-id="{{ $folder->id }}"></i>
            
            <div class="options-wrap">
                <div class="options">
                    <a href="#" class="option-link create-subfolder-option">
                        <p>Nueva subcarpeta</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Permisos</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Copiar a...</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Mover a...</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Eliminar</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Cambiar nombre</p>
                        <span>></span>
                    </a>
                    <a href="#" class="option-link">
                        <p>Propiedades</p>
                        <span>></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
    @if(count($folder->subfolders) > 0)
        <ul id="folder-content-{{ $folder->id }}" class="folder-content my-0">
            @foreach($folder->subfolders as $subfolder)
                @include('documents.folders', ['folder' => $subfolder, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
