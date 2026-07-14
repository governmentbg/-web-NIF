@extends('layouts.app')

@section('content')
<?php
$sitemap = \App\Helpers\DataHelper::load()['sitemap'];
function renderSitemap(array $items)
{
    echo "<ul>";
    foreach ($items as $item) {
        echo "<li>";
        echo "<a href='" . route($item['route']) . "' title='" . $item['title'] . "' >" . $item['title'] . "</a>";
        if (!empty($item['children'])) {
            renderSitemap($item['children']);
        }
        echo "</li>";
    }
    echo "</ul>";
}
?>

@section('title',"Карта на сайта")
<div class="page sitemap container py-4">

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Начало</a></li>
            <li class="breadcrumb-item active">Карта на сайта</li>
        </ol>
    </nav>
    <div class="page-content py-4">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="page-title mb-4">Карта на сайта</h2>
            </div>
            <div class="col-sm-12">
                <div class="sitemap-list" aria-label="Карта на сайта">
                    {{ renderSitemap($sitemap) }}
                </div>
            </div>

        </div>

    </div>


    @endsection