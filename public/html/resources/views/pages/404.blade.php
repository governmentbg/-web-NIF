@extends('layouts.app')
@section('title', '404')

@section('content')
<div class="page 404 py-5 flex-grow-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 p-4">
                <img src="{{ asset('assets/img/404.png') }}" class="img-fluid" alt="404" title="404">
            </div>
            <div class="col-sm-12 col-md-6 p-4">
                <h1 class="mb-3 fw-bold">Тази страница не съществува</h1>
                <p>Ето няколко от най-честите причини за това:</p>
                <ul>
                    <li>Грешно въведен адрес
                    <li>Грешка при копиране на адреса
                    <li>Непълен адрес
                    <li>Преместено съдържание
                    <li>Изтрита страница
                </ul>
                <p class="m-0">Моля, опитайте отново или използвайте полето за търсене, за да потърсите съдържанието, което Ви интересува.</p>
            </div>
        </div>
    </div>
</div>
@endsection