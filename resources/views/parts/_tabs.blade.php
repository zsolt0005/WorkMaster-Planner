@php
    /** @var array<string, string> $tabs */
    $tabs = $tabs ?? []
@endphp

<div class="btn-group mb-3">
    @foreach($tabs as $path => $title)
        <a type="button" class="btn {{ request()->routeIs($path) ? 'btn-primary' : 'btn-outline-primary' }}" href="{{ route($path) }}">{{ $title }}</a>
    @endforeach
</div>
