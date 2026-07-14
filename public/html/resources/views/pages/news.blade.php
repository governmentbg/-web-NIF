@extends('layouts.app')
@section('title', 'Новини и събития')

@section('content')
@php
$news1 = \App\Helpers\DataHelper::load()['news']['items'];
$news = array_merge($news1, $news1, $news1);
@endphp
<div class="page container py-4">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item active">Новини</li>
        </ol>
    </nav>
    <div class="page-content py-4">
        <section class="news">
            <div class="row gy-4">

                <!-- news section -->
                @foreach($news as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <figure class="card-img-top">
                            <img src="{{ asset('assets/img/' . $post['img']) }}" class="img-fluid">
                        </figure>
                        <div class="card-body p-4">
                            <p class="text-secondary mb-2">
                                {{ $post['date'] }}
                            </p>
                            <a href="{{ route($post['url']) }}"
                                class="card-text stretched-link text-decoration-none fs-5">
                                {{ $post['title'] }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- end news section -->

            </div>
        </section>
    </div>


    @endsection