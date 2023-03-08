@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">Registrar Tasa</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ sc_route_admin('tasa_cambio') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> Registrar Tasa</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('tasa_cambio.crear')}}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tasa</th>
                                <th scope="col">Fecha</th>
                          
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ( $tipocambio as  $key => $cambio)
                                    
                           
                              <tr>
                                <th scope="row">{{$key}}</th>
                                <td>{{ $cambio->valor }}</td>
                                <td>{{ $cambio->fecha }}</td>
                               
                              </tr>
                              @endforeach
                             
                            </tbody>
                          </table>
                     

                    </div>
                    <!-- /.card-body -->


                    <div class="card-footer row" id="card-footer">
                        @csrf
                        <div class="col-md-2">
                        </div>
    
                        <div class="col-md-8">
                         
                            {{ $tipocambio->links() }}
                            
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </form>
        </div>
    </div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush
