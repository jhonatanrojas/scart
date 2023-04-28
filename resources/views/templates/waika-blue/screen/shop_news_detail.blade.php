@php
/*
$layout_page = shop_news_detail
**Variables:**
- $news: no paginate
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <img class="img-fluid w-100 mb-3 rounded" src="{{ sc_file($news->getThumb()) }}" alt="">
                <h1 class="">{{ $news->title }}</h1>
                {!! sc_html_render($news->content) !!}
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
