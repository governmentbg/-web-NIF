@extends('layouts.app')
@section('title', 'Контакти')

@section('content')
<div class="page container py-4">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item active">Контакти</li>
        </ol>
    </nav>
    <div class="page-content py-4">
        <div class="row mb-4">
            <div class="col-sm-12">
                <h2 class="page-title mb-4">Контакти</h2>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body bg-info p-4">
                        <h5>За контакти</h5>
                        <p>Кандидатстване по програми<br>
                            +359 2 940 11 01
                            <br><br>
                            Текущи проекти и отчети<br>
                            +359 2 940 11 02
                            <br><br>
                            Финанси и договори<br>
                            +359 2 940 11 03
                        </p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body bg-info p-4">
                        <h5>Адрес</h5>
                        <p>
                            гр. София 1000<br>
                            бул. „Княз Александър Дондуков“ № 24br>
                            Национален иновационен фонд

                        </p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body bg-info p-4">
                        <h5>E-mail</h5>
                        <p><i class="fas fa-arrow-up-right-from-square me-2"></i>info@nif.bg</p>
                    </div>
                </div>


            </div>
            <div class="col-md-8">
                <h5 class="mb-4">Свържете се с нас</h5>

                <div class="alert alert-success mt-4" role="alert">
                    Вашето съобщение е изпратено успешно. Ще се свържем с вас възможно най-скоро. Благодарим ви, че се свързахте с нас!
                </div>
                <a href="{{ route('home') }}" class="btn btn-secondary text-white"><i class="fas fa-arrow-left me-2"></i>Начало</a> <a href="{{ route('contacts') }}" class="btn btn-outline-secondary">Контакти</a>
            </div>
        </div>

    </div>


    @endsection