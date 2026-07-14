@extends('layouts.app')
@section('title', 'Национален иновационен фонд')

@section('content')
@php
$page = \App\Helpers\DataHelper::load()['home'];
$news = \App\Helpers\DataHelper::load()['news'];
$programs = \App\Helpers\DataHelper::load()['programs'];
$partners = \App\Helpers\DataHelper::load()['partners']['items'];
@endphp

<section class="home bg-transparent my-md-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-8" data-animation="fadeInUp">
                <h3>
                    Програма за насърчаване на научноизследователската и иновационната дейност чрез подкрепа за
                    разработване, внедряване и мащабиране на високотехнологични решения, базирани на изкуствен интелект,
                    дигитализация, зелени технологии и устойчиво индустриално развитие в българските предприятия
                </h3>
                <p>
                    Програмата е насочена към стимулиране на конкурентоспособността и технологичната трансформация на
                    българските предприятия чрез целенасочено финансиране на иновационни проекти с висока добавена
                    стойност.
                </p>
                <a href="#" class="btn btn-outline-primary">
                    Виж повече
                </a>
            </div>
            <div class="col-md-4" data-group="cards">
                <div class="card info bordered mb-4" data-animation="slideInRight">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-0 fw-bold">Онлайн кандидатстване през ИСУН</h3>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>

                <div class="card light bordered" data-animation="slideInRight">
                    <div class="card-body p-4 d-flex flex-column align-items-start">
                        <h3 class="card-title mb-0 fw-bold">Кандидатстване през</h3>
                        <img src="{{ asset('assets/img/eureka-logo.png') }}">
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row gy-4">
            <!-- blocks section -->
            @foreach($page['blocks'] as $block)
            <div class="col-md-4">
                <div class="card bordered info-block h-100" data-animation="fadeInUp" data-duration="500" data-delay="{{ ($loop->index+1)*150 }}">
                    <div class="card-body p-4">
                        <figure class="card-img-top">
                            <img src="{{ asset('assets/img/' . $block['img']) }}">
                        </figure>
                        <h3 class="card-title">{{ $block['title'] }}</h3>
                        <p class="card-text">
                            {{ $block['text'] }}
                        </p>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- end blocks section -->
        </div>
    </div>
</section>

<section class="programs bg-gradient-blue">
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-8 col-md-9">
                <h1 class="title">Активни Програми</h1>
            </div>
            <div class="col-sm-4 col-md-3 text-md-end text-sm-left">
                <a href="{{ route('programs') }}" class="btn btn-outline-light">
                    Всички програми
                </a>
            </div>
        </div>

        <div class="row gy-4">
            <!-- programs section -->
            @foreach(array_slice($programs['items'], 0, 3) as $program)
            <?php
            $card_class = $program['status'] === 1 ? 'active' : ($program['status'] === 2 ? 'upcomming' : 'past');
            $program_status = $program['status'] === 1 ? 'Активна' : ($program['status'] === 2 ? 'Предстояща' : 'Минала');
            ?>
            <div class="col-12">
                <div class="card bordered {{  $card_class }}" data-animation="fadeIn" data-duration="500" data-delay="{{ ($loop->index+1)*150 }}">
                    <div class="card-body p-0 mb-2">
                        <div class="row m-0">
                            <div class="col-md-4 bg">
                                <h4 class="card-title p-4 m-0">
                                    <a href="#" class="stretched-link"
                                        title="{{ $program['title'] }}">{{ $program['title'] }}</a>
                                </h4>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex justify-content-end">
                                    <span class="badge badge-top mb-4 mt-n3">
                                        {{ $program_status }}
                                    </span>
                                </div>
                                <div class="p-4">{{ $program['summary'] }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-4">
                                    <div class="d-flex justify-content-end">
                                        <span class="badge badge-bottom mb-4">
                                            {{ $program_status }}
                                        </span>
                                    </div>

                                    <p>
                                        <span class="fw-bold">Срок на изпълнение</span><br>
                                        {{ $program['period'] }}
                                    </p>
                                    <hr>
                                    <p>
                                        <span class="fw-bold">Бюджет</span><br>
                                        {{ $program['budget'] }} лв.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
            <!-- end programs section -->
        </div>
    </div>
</section>

<section class="news bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-8 col-md-9">
                <h1 class="title">{{ $news['title'] }}</h1>
            </div>
            <div class="col-sm-4 col-md-3 text-md-end text-sm-left">
                <a href="#" class="btn btn-outline-primary">
                    Всички новини
                </a>
            </div>
        </div>
        <div class="row gy-4">

            <!-- news section -->
            @foreach($news['items'] as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100" data-animation="fadeIn" data-duration="500" data-delay="{{ ($loop->index+1)*150 }}">
                    <figure class="card-img-top">
                        <img src="{{ asset('assets/img/' . $post['img']) }}" class="img-fluid">
                    </figure>
                    <div class="card-body p-4">
                        <p class="text-secondary mb-2">
                            {{ $post['date'] }}
                        </p>
                        <a href="{{ route($post['url']) }}" class="card-text stretched-link text-decoration-none fs-5">
                            {{ $post['title'] }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- end news section -->

        </div>

    </div>
</section>


<section class="news bg-white">
    <div class="container">
        <div class="row gy-4">

            <!-- news 2 section -->
            @foreach($news['items'] as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100" data-animation="fadeIn" data-duration="500" data-delay="{{ ($loop->index+1)*150 }}">
                    <figure class="card-img-top">
                        <img src="{{ asset('assets/img/' . $post['img']) }}" class="img-fluid">
                    </figure>
                    <div class="card-body p-4">
                        <p class="text-secondary mb-2">
                            {{ $post['date'] }}
                        </p>
                        <a href="{{ route($post['url']) }}" class="card-text stretched-link text-decoration-none fs-5">
                            {{ $post['title'] }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- end news 2 section -->

        </div>
    </div>
</section>

<section class="partners bg-light">
    <div class="container">
        <div class="row gy-1">

            <!-- partners section -->
            @foreach($partners as $partner)
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <figure class="partner-logo" data-animation="zoomIn" data-duration="500" data-delay="{{ ($loop->index+1)*150 }}">
                    <a href="{{ $partner['url']}} "><img src="{{ asset('assets/img/' . $partner['img']) }}"
                            class="img-fluid"></a>
                </figure>
            </div>
            @endforeach
            <!-- end partners section -->

        </div>

    </div>
</section>

@endsection