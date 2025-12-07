<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'WorkMaster Planner')</title>

        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- CSS FILES -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/templatemo-leadership-event.css') }}" rel="stylesheet">

        @vite(['resources/css/app.css'])
    </head>
    <body>
        @yield('header')

        <main>
            @php($flashes = session('flash', []))
            @if(!empty($flashes))
                <div class="container pt-2">
                    @foreach(session('flash', []) as $flash)
                        <div class="alert alert-{{ $flash['type'] }}">{!! $flash['message'] !!}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>

        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/jquery.sticky.js') }}"></script>

        @vite(['resources/js/app.js'])
    </body>
</html>
