@php
$data = \App\Helpers\DataHelper::load();
@endphp

<nav class="bg-white shadow-sm" data-animation="fadeIn" data-duration="300">
    <div class="container">
        <ul class="nav justify-content-end">
            @foreach($data['top_menu'] as $item)
            <li class="nav-item">
                <a class="nav-link" href="{{ route($item['route']) }}">
                    {{ $item['title'] }}
                </a>
            </li>
            @endforeach
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa fa-search"></i></a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">EN</a>
            </li>

        </ul>
    </div>
</nav>


<header>
    <div class="container">
        <div class="py-5 d-flex align-items-center">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('assets/img/state-brand-en.svg') }}" alt="Logo" class="logo" data-animation="zoomIn" data-duration="300">
            </a>
            <div class="ms-2">
                <img src="{{ asset('assets/img/logo-nif.svg') }}" alt="Logo" class="logo" data-animation="zoomIn" data-duration="500">
            </div>

        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary py-0 px-3" data-animation="fadeInUp" data-duration="500" data-delay="150">

            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    @foreach($data['menu'] as $item)
                    <li class="nav-item {{ !empty($item['submenu']) ? 'dropdown' : '' }}">
                        @if(!empty($item['submenu']))
                        <a class="nav-link dropdown-toggle {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                            data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <span>{{ $item['title'] }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($item['submenu'] as $subItem)
                            <li><a class="dropdown-item {{ request()->routeIs($subItem['route']) ? 'active' : '' }}"
                                    href="{{ route($subItem['route']) }}">{{ $subItem['title'] }}</a></li>
                            @endforeach

                        </ul>
                        @else
                        <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                            href="{{ route($item['route']) }}">
                            <span>{{ $item['title'] }}</span>
                        </a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>

        </nav>
    </div>
</header>