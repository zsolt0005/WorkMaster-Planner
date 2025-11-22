@php
    /** @var array<string, string> $tabs */
    $tabs = $tabs ?? []
@endphp

<div class="btn-group d-flex mb-3">
    @foreach($tabs as $path => $title)
        <a class="btn flex-fill {{ request()->routeIs($path) ? 'btn-primary' : 'btn-outline-primary' }}"
           href="{{ route($path) }}">
            {{ $title }}
        </a>
    @endforeach
</div>
