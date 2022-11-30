@extends($templatePathAdmin.'layout')

@section('main')
<div class="table-responsive">
    <table class="table table-hover box-body text-wrap table-bordered">
      <thead>
        <tr>
                            <th>plantilla</th>
                          <th>inicial</th>
                          <th>Estatus</th>
                          <th>Acción</th>
                       </tr>
      </thead>
                    <tbody>

                        @foreach ($borrado_html as $plantilla )


                        {{dd($plantilla)}};
                        @endforeach
                    
                  </tbody>
    </table>
    </div>

@endsection

@push('styles')

@endpush

@push('scripts')
@include($templatePathAdmin.'component.ckeditor_js')

<script type="text/javascript">
    $('textarea.editor').ckeditor(
    {
        filebrowserImageBrowseUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}?type=content',
        filebrowserImageUploadUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=content&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}?type=Files',
        filebrowserUploadUrl: '{{ sc_route_admin('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=file&_token={{csrf_token()}}',
        filebrowserWindowWidth: '900',
        filebrowserWindowHeight: '600'
    }
);
</script>

@endpush