@extends('layouts.app')
@section('title', 'Контакти')

@section('content')
<div class="page container py-4">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item active">Документи</li>
        </ol>
    </nav>
    <div class="page-content py-4">
        <div class="row mb-4">
            <div class="col-sm-12">
                <h2 class="page-title mb-4">Документи</h2>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col">
                <div class="mb-4">
                    <h4 class="mb-4">Процедура за избор на членове на изпълнителния съвет на НИФ</h4>
                    @include('pages.partials.donwload-files')
                </div>
                <div class="mb-4">
                    <h4 class="mb-4">Процедура за избор на членове на изпълнителния съвет на НИФ</h4>
                    @include('pages.partials.donwload-files')
                </div>
            </div>
        </div>

    </div>


    @endsection