@php
$footer_menu_left = \App\Helpers\DataHelper::load()['menu'];
$footer_menu_right = \App\Helpers\DataHelper::load()['footer_menu'];
@endphp

<footer class="mt-auto">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <a href="{{ route('home') }}" class="brand">
                            <img src="{{ asset('assets/img/nif-brand-en.svg') }}" alt="Logo" class="logo w-100">
                        </a>
                        <p class="text-white mt-4">
                            <abbr>Адрес</abbr><br>
                            гр. София – 1000, ул. "Княз Александър I" 12<br>
                            <abbr>E</abbr>: docs@mig.government.bg<br>
                            <abbr>Т</abbr>: +359 2 807 5381
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach($footer_menu_left as $link)
                            <li><a href="{{ route($link['route']) }}">{{ $link['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach($footer_menu_right as $link)
                            <li><a href="{{ route($link['route']) }}">{{ $link['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>