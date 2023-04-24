{{-- <div class="pagination-wrap">
    <nav aria-label="Page navigation">
      <ul class="pagination">
      </ul>
    </nav>
  </div> --}}
  <div class="py-5">
    <style>
      .active>.page-link, .page-link.active {
          z-index: 3;
          color: #fff;
          background-color: #0080B6;
          border-color: #0080B6;
      }
    </style>
    {{ $items->appends(request()->except(['page','_token']))->links() }}
  </div>