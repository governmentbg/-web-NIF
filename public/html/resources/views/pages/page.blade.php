@extends('layouts.app')

@section('content')
@php
$page = \App\Helpers\DataHelper::load()['page'];
@endphp

@section('title', $page['title'])
<div class="container py-4">
    <h1>{{ $page['title'] }}</h1>
    <h6>{{ $page['subtitle'] }}</h6>
    <p>{{ $page['content'] }}</p>
</div>

<div class="container my-5">

    <h1 class="mb-5">Bootstrap 5 – Cheatsheet</h1>

    <!-- ================= BUTTONS ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Buttons</h2>

        <div class="mb-3">
            <button class="btn btn-primary me-2">Primary</button>
            <button class="btn btn-secondary me-2">Secondary</button>
            <button class="btn btn-success me-2">Success</button>
            <button class="btn btn-danger me-2">Danger</button>
            <button class="btn btn-warning me-2">Warning</button>
            <button class="btn btn-info me-2">Info</button>
            <button class="btn btn-light me-2">Light</button>
            <button class="btn btn-dark me-2">Dark</button>
            <button class="btn btn-link">Link</button>
        </div>

        <div class="mb-3">
            <button class="btn btn-outline-primary me-2">Outline Primary</button>
            <button class="btn btn-outline-secondary me-2">Outline Secondary</button>
            <button class="btn btn-outline-success me-2">Outline Success</button>
            <button class="btn btn-outline-danger">Outline Danger</button>
        </div>

        <div class="mb-3">
            <button class="btn btn-primary btn-sm me-2">Small</button>
            <button class="btn btn-primary me-2">Default</button>
            <button class="btn btn-primary btn-lg">Large</button>
        </div>

        <div class="btn-group mb-3">
            <button class="btn btn-primary">Left</button>
            <button class="btn btn-primary">Middle</button>
            <button class="btn btn-primary">Right</button>
        </div>

        <div>
            <button class="btn btn-primary" disabled>Disabled</button>
        </div>
    </section>

    <!-- ================= BREADCRUMBS ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Breadcrumbs</h2>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </section>

    <!-- ================= CARDS ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Cards</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Basic card</h5>
                        <p class="card-text">Simple card body text.</p>
                        <a href="#" class="btn btn-primary btn-sm">Action</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Light card</h5>
                        <p class="card-text">Contextual background.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-header">Header</div>
                    <div class="card-body">
                        <p class="card-text">Card with header.</p>
                    </div>
                    <div class="card-footer text-muted">Footer</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= BADGES ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Badges</h2>

        <div class="mb-3">
            <span class="badge bg-primary">Primary</span>
            <span class="badge bg-secondary">Secondary</span>
            <span class="badge bg-success">Success</span>
            <span class="badge bg-danger">Danger</span>
            <span class="badge bg-warning text-dark">Warning</span>
            <span class="badge bg-info text-dark">Info</span>
            <span class="badge bg-light text-dark">Light</span>
            <span class="badge bg-dark">Dark</span>
        </div>

        <button class="btn btn-primary">
            Notifications <span class="badge bg-light text-dark ms-1">4</span>
        </button>
    </section>

    <!-- ================= FORMS ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Form elements</h2>

        <form>

            <div class="mb-3">
                <label class="form-label">Text input</label>
                <input type="text" class="form-control" placeholder="Text input">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="email@example.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Textarea</label>
                <textarea class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Select</label>
                <select class="form-select">
                    <option selected>Choose...</option>
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Multiple select</label>
                <select class="form-select" multiple>
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">File input</label>
                <input type="file" class="form-control">
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="check1">
                <label class="form-check-label" for="check1">Checkbox</label>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="radio" id="radio1">
                <label class="form-check-label" for="radio1">Radio 1</label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="radio" id="radio2">
                <label class="form-check-label" for="radio2">Radio 2</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Range</label>
                <input type="range" class="form-range">
            </div>

            <div class="mb-3">
                <label class="form-label">Disabled input</label>
                <input type="text" class="form-control" disabled value="Disabled">
            </div>

            <button class="btn btn-primary">Submit</button>

        </form>
    </section>

    <!-- ================= ACCORDION ================= -->
    <section class="mb-5">
        <h2 class="mb-3">Accordion</h2>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne">
                        Accordion Item #1
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        Content for first accordion panel.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo">
                        Accordion Item #2
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Content for second accordion panel.
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


@endsection