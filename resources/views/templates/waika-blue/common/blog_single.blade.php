<article class="card">
  <a class="" href="{{ $blog->getUrl() }}">
    <img src="{{ sc_file($blog->getThumb()) }}" alt="" class="card-img-top">
  </a>
  <div class="card-body">
      <h5 class="card-title"><a href="{{ $blog->getUrl() }}">{{ $blog->title }}</a></h5>
      <p class="card-text">{{ $blog->description }}</p>
      <a href="{{ $blog->getUrl() }}" class="card-link">Leer más</a>
  </div>
  <div class="card-footer text-muted text-center">
    <time datetime="{{ $blog->created_at }}">{{ $blog->created_at }}</time>
  </div>
</article>