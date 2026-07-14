@php
$files = \App\Helpers\DataHelper::load()['files'];
@endphp

<div class="download-files list-group list-group-flush">
    @foreach($files as $file)
    <a href="{{ route('download-file') }}" class="list-group-item list-group-item-action d-flex flex-row">
        <div class="d-flex align-items-center p-4">
            <i class="fas fa-cloud-arrow-down fa-xl"></i>
        </div>
        <div class="d-flex w-100 flex-column">
            <span class="pb-2">{{ $file['title'] }}</span>
            <span class="text-secondary">{{ $file['type']}}, {{ $file['size']}}, Актуален {{ $file['date'] }}</span>
        </div>
    </a>
    @endforeach
</div>