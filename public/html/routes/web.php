<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Helpers\DataHelper;

$data = DataHelper::load();

Route::get('/', function () {
    return view('pages.home', ['title' => 'Начало']);
})->name('home');

// available routes
$routes = [
    'about',
    'projects',
    'documents',
    'news',
    'contacts',
    'sitemap',
    'privacy',
    'terms',
    '404',
    'mission',
    'page',
    'team',
    'programs',
    'programs-single',
    'news-single',
    'upcomming-programs',
    'past-programs',
    'candidature',
    'declaration',
    'anticorruption',
    'accessibility',
    'download-file',
    '404',
    '500',
    'contacts-sent',
    'stemap'
];

// Генериране на страници от routes
foreach ($routes as $route) {


    Route::get("/{$route}", function () use ($route) {

        if (!View::exists("pages." . $route)) {
            return response()->view("pages.404");
        }

        return view("pages.{$route}");
    })->name($route);
}
