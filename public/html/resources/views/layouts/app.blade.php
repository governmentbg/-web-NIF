<!DOCTYPE html>
<html lang="bg" class="h-100" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/accessibility/accessibility.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon.svg') }}">
</head>

<body class="d-flex flex-column h-100 {{ request()->routeIs('home') ? 'home' : '' }}">
    @include('layouts.partials.header')
    <main class="flex-grow-1"
        @unless(request()->routeIs('home'))
        data-animation="fadeIn"
        data-on="load"
        data-duration="500"
        data-delay="500"
        @endunless
        >
        <div class="w-100 h-100">
            @yield('content')
        </div>
    </main>
    @include('layouts.partials.footer')
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/lightgallery.js') }}"></script>
    <script src="{{ asset('assets/accessibility/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/accessibility.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>