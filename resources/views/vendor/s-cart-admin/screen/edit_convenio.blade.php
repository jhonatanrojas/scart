@extends($templatePathAdmin.'layout')

@section('main')
<div class="table-responsive">
    <table class="table table-hover box-body text-wrap table-bordered">
      <thead>
        <tr>
                            <th>No.</th>
                          <th>inicial</th>
                          <th>Estatus</th>
                          <th>Acción</th>
                       </tr>
      </thead>
                    <tbody>

                        @foreach ($borrado_html as $plantilla )
                        @php
                        $n = (isset($n)?$n:0);
                        $n++;
                        @endphp

                        


                                <tr>
                                    <td>{{$n}}</td>
                                <td>
                                    @if ($plantilla->name == "sin_inicial")

                                        Sin iniacial

                                    @else
                                        Con incial
                                        
                                    @endif
                                </td>
                                <td><span class="badge badge-success">ON</span></td>
                                <td>
                    <a href="{{ route('editar_convenio', ['id' => $plantilla->id]) }}"><span title="action.admin.edit" type="button" class="btn btn-flat btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    {{-- <span onclick="deleteItems({{$plantilla->id}});" title="Borrar" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span> --}}
                    </td>
                        </tr>
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