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
                <form class="row needs-validation" method="get" action="{{ route('contacts-sent') }}" novalidate>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <label for="name" class="form-label">Вашите имена *</label>
                            <input type="text" class="form-control" id="name" placeholder="Иван Иванов" aria-describedby="nameHelpBlock" required>
                            <div id="nameHelpBlock" class="form-text">
                                <i class="far fa-circle-check me-2"></i>Въведете вашето име и фамилия
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="subject" class="form-label">Относно</label>
                            <!-- use is-valid for a valid form data -->
                            <input type="text" class="form-control is-valid" id="subject" placeholder="Програма" aria-describedby="subjectHelpBlock">
                            <div id="subjectHelpBlock" class="form-text">
                                <i class="far fa-circle-check me-2"></i>Посочете предмета на Вашето запитване
                            </div>
                        </div>


                        <div class="mb-4">
                            <label for="email" class="form-label">Имейл адрес *</label>
                            <!-- use is-invalid for invalid form data -->
                            <input type="text" class="form-control is-invalid" id="email" placeholder="Програма" aria-describedby="emailHelpBlock" required>
                            <div id="emailHelpBlock" class="form-text">
                                <i class="far fa-circle-check me-2"></i>Използвайте имейл адрес, който проверявате редовно
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end">
                        <div class="mb-4 text-start">
                            <label for="message" class="form-label">Вашето съобщение</label>
                            <textarea id="message" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="d-grid d-md-block">
                            <button class="btn btn-secondary text-white" type="submit">Изпрати</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>


    @endsection