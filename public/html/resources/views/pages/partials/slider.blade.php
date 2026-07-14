<?php
$slides = [
    [
        'image' => asset('assets/img/demo/news-01.jpg'),
        'title' => 'Новина 1',
        'description' => 'Описание на снимката 1',
    ],
    [
        'image' => asset('assets/img/demo/news-02.jpg'),
        'title' => 'Новина 2',
        'description' => 'Описание на снимката 2',
    ],
    [
        'image' => asset('assets/img/demo/news-03.jpg'),
        'title' => 'Новина 3',
        'description' => 'Описание на снимката 3',
    ],
    [
        'image' => asset('assets/img/demo/news-01.jpg'),
        'title' => 'Новина 1',
        'description' => 'Описание на снимката 4',
    ],
    [
        'image' => asset('assets/img/demo/news-02.jpg'),
        'title' => 'Новина 2',
        'description' => 'Описание на снимката 5',
    ],
    [
        'image' => asset('assets/img/demo/news-03.jpg'),
        'title' => 'Новина 3',
        'description' => 'Описание на снимката 6',
    ],
];
?>

<div class="position-relative">
    <div class="swiper" id="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach ($slides as $slide)
            <div class="swiper-slide">
                <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="img-fluid"
                    data-src="{{ $slide['image'] }}"
                    data-sub-html="<h4>{{ $slide['title'] }}</h4><p>{{ $slide['description'] }}</p>">
            </div>
            @endforeach
        </div>
    </div>

    <div class="swiper-navigation position-relative d-flex mt-2">
        <div class="btn btn-light rounded-0 button-prev m-0"><i class="fas fa-chevron-left"></i></div>
        <div class="btn btn-light rounded-0 button-next m-0"><i class="fas fa-chevron-right"></i></div>
    </div>
</div>