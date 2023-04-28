@php
$categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
@endphp

@if ($categoriesTop->count())
  <div class="col-12">
      <h6 class="aside-title">{{ sc_language_render('front.categories') }}</h6>
      
      <div class="nav flex-column">
        @foreach ($categoriesTop as $key => $category)
        <a href="{{ $category->getUrl() }}" class="nav-link" aria-current="page">
          {{ $category->title }}
        </a>
        @endforeach
      </div>
  </div>
@endif