@extends('layouts.app')

@section('content')
@php
$programs = \App\Helpers\DataHelper::load()['programs']['items'];
$program = \App\Helpers\DataHelper::load()['programs']['items'][0];
@endphp

@section('title', $program['title'])
<div class="page programs container py-4">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item"><a href="{{ route('programs') }}">Програми</a></li>
            <li class="breadcrumb-item active">{{ $program['title'] }}</li>
        </ol>
    </nav>
    <div class="py-4">

        <div class="card bg-light mb-4">
            <div class="row">
                <div class="col-lg-4 d-flex order-2 order-lg-1">
                    <div class="card-body p-4 justify-content-center d-flex flex-column">

                        <h2 class="card-title">
                            {{ $program['title'] }}
                        </h2>
                        <p class="text-secondary mb-2">
                            {{ $program['date'] }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 order-1 order-lg-2">
                    <figure class="m-0">
                        <img src="{{ asset('assets/img/program-wallpaper.jpg') }}" class="img-fluid">
                    </figure>

                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-4 d-flex flex-column mt-md-4 order-2 order-lg-1">
                <div class="my-md-5"></div>
                <!-- programs sidebar -->
                <div class="more-news position-sticky top-0  mt-md-4 pt-2">
                    <a href="{{ route('programs-single') }}" class="d-flex justify-content-between align-items-center text-decoration-none fw-bold text-secondary">
                        <span class="fs-5">Предходна програма</span> <i class="fa fa-chevron-left"></i></a>
                    <p class="py-2">
                        {{ $programs[0]['title'] }}
                    </p>

                    <a href="{{ route('programs-single') }}" class="d-flex justify-content-between text-decoration-none fw-bold text-secondary">
                        <span class="fs-5">Следеваща програма</span> <i class="fa fa-chevron-right"></i></a>
                    <p class="py-2">
                        {{ $programs[2]['title'] }}
                    </p>

                </div>
                <!-- end programs sidebar -->
            </div>

            <div class="col-lg-8 page-content mt-4 order-1 order-lg-2">
                <div class="row mb-4 gy-4">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body bg-info p-4">
                                <h5>Статус</h5>
                                Активна
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body bg-info p-4">
                                <h5>Предприятие</h5>
                                Микро
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body bg-info p-4">
                                <h5>Район на дейсност</h5>
                                Градски
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 gy-4">

                    <!-- program content section-->
                    <div class="col-sm-12">
                        <h4 class="mb-4">
                            Основна цел на проекта
                        </h4>
                        <p>
                            Дейностите по проекта са насочени в подкрепа на микро-, малките и средните предприятия в Северните райони на България чрез създаването и функционирането
                            на мобилни екипи, които да предоставят информация и съдействие за участие в европейски и национални програми, както и персонализирани услуги за бизнес
                            развитие и растеж. Основната мисия е да се повиши конкурентоспособността на предприятията в Северна България и да се стимулира тяхната устойчивост.
                        </p>
                        <p>
                            Проектът има за цел да осигури адекватна информация и експертна подкрепа на МСП относно възможностите за европейско и национално финансиране,
                            условия за кандидатстване и изпълнение на процедури за предоставяне на безвъзмездна финансова помощ. Чрез индивидуализиран подход, мобилните екипи ще
                            съдействат на предприятията в идентифициране на най-подходящите актуални или предстоящи процедури, инциативи и инструменти в помощ на МСП.
                        </p>
                    </div>

                    <div class="col-sm-12">
                        <h4 class="mb-4">
                            Основни етапи
                        </h4>
                        <p>
                            Създаване на мобилни екипи; Проактивно популяризиране на мерки, програми, инструменти и други инициативи, изпълнявани от ИАНМСП, МИР и други национални,
                            европейски и международни структури, в помощ на МСП; Предоставяне на персонализирани услуги за бизнес развитие и растеж; Създаване на менторска програма;
                            Организиране на обучения; Създаване на мрежи за подкрепа.
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <h4 class="mb-4">
                            Очакваните резултати
                        </h4>
                        <p>
                            Създаване на по-устойчиви и по-конкурентоспособни предприятия в Северните райони на България с повишена икономическа активност, подобрен достъп до финансиране и разширени пазарни позиции,
                            а оттук и цялостно подобряване на бизнес средата и условията за развитие и растеж на местно ниво. Посочените резултати ще подпомогнат цялостното развитие на Северните райони и ще допринесат
                            за намаляване на регионалните различия в страната.
                        </p>
                    </div>
                    <!-- end program content section -->

                    <div class="col-sm-12">
                        <hr class="border-bottom-1 border-light opacity-100">
                    </div>

                    <!-- program info section-->
                    <div class="col-sm-12">
                        <h4 class="mb-4">
                            Информация за проекта
                        </h4>
                        @include('pages.partials.program-info')
                    </div>
                    <!-- end program info section -->

                    <div class="col-sm-12">
                        <hr class="border-bottom-1 border-light opacity-100">
                    </div>

                    <!-- download files section -->
                    <div class="col-sm-12">
                        <h4 class="mb-4">
                            Свързани документи
                        </h4>
                        @include('pages.partials.donwload-files')
                    </div>
                    <!-- end download files section -->

                </div>

            </div>
        </div>


        @endsection