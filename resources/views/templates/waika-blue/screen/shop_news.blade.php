@php
/*
$layout_page = shop_news
**Variables:**
- $news: paginate
Use paginate: $news->appends(request()->except(['page','_token']))->links()
*/
@endphp


@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default">
    <div class="container">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @if ($news->count())
            @foreach ($news as $newsDetail)
            <div class="card-group">
              {{-- Render product single --}}
              @include($sc_templatePath.'.common.blog_single', ['blog' => $newsDetail])
              {{-- //Render product single --}}
            </div>
            @endforeach

            {{-- Render pagination --}}
            @include($sc_templatePath.'.common.pagination', ['items' => $news])
            {{--// Render pagination --}}
        @else
            {!! sc_language_render('front.data_notfound') !!}
        @endif
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