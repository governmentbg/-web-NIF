@extends('layouts.fullscreen')
@section('title', '500')

@section('content')
<div class="page 500 d-flex flex-grow-1">
    <div class="container m-auto">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6 p-4">
                <img src="{{ asset('assets/img/500.png') }}" class="img-fluid" alt="500" title="500">
            </div>
            <div class="col-sm-12 col-md-6 p-4 text-center text-md-start">
                <h1 class="mb-3 fw-bold">Грешка на сървъра</h1>
                <p>Сървърът се натъкна на грешка или неправилна конфигурация и не успя да изпълни Вашата заявка.</p>
            </div>
        </div>
    </div>
</div>
@endsection