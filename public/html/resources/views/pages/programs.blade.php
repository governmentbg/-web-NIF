@extends('layouts.app')
@section('title', 'Програми')

@section('content')
@php
$programs = \App\Helpers\DataHelper::load()['programs']['items'];
@endphp
<div class="page container py-4">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item active">Програми</li>
        </ol>
    </nav>
    <div class="page-content py-4">
        <section class="programs">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="page-title mb-4">Активни Програми</h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12">
                    @include('pages.partials.programs-filter')
                </div>
                <div class="col-sm-12 text-end py-2 d-none d-md-block">
                    Изберете изглед

                    <div class="btn-group" role="group">
                        <a href="#" class="btn btn-link pe-1" id="grid-view-btn">
                            <i class="fa-solid fa-grip fa-2x"></i>
                        </a>
                        <a href="#" class="btn btn-link ps-1 pe-0 active" id="list-view-btn">
                            <i class="fa-regular fa-rectangle-list fa-2x"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="row gy-4">
                <!-- programs section -->
                @foreach($programs as $program)
                <?php
                $card_class = $program['status'] === 1 ? 'active' : ($program['status'] === 2 ? 'upcomming' : ($program['status'] === 3 ? 'in_progress': 'past'));
                $program_status = $program['status'] === 1 ? 'Активна' : ($program['status'] === 2 ? 'Предстояща' : ($program['status'] === 3 ? 'В изпълнение': 'Минала'));
                ?>
                <div class="col-12">
                    <div class="card bordered {{  $card_class }}">
                        <div class="card-body p-0 mb-2">
                            <div class="row m-0">
                                <div class="col-md-4 bg">
                                    <h4 class="card-title p-4 m-0">
                                        <a href="{{ route('programs-single') }}" class="stretched-link"
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
            <div class="row mt-4">
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#"><i
                                        class="fa-solid fa-chevron-left"></i></a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link active" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i
                                        class="fa-solid fa-chevron-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        </section>

    </div>


    @endsection