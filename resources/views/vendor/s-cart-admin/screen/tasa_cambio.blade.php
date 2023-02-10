@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">registrar Tasa</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ route('list_tasa_cambio') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('tasa_cambio.crear')}}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-6">

                           

                            <div class="form-group col-12   {{ $errors->has('valor') ? ' text-red' : '' }}">
                                <label for="name" class="col-sm-2 col-form-label">Tasa Bs</label>
                       
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="valor" name="valor" value="{{ old()?old('valor'):$currency['valor']??'0' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('valor'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('valor') }}
                                            </span>
                                        @endif
                               
                            </div>

               
                                <div class="form-group col-12 ">
                                    <label for="forma_pago">Moneda</label>
                                    <select id="forma_pago" name="moneda" required class="form-control">
                                        <option value="USD"> USD</option>
                                            <option option="EUR">EUR</option>
                                    </select>  
                                  </div>
                           
                                <div class="form-group col-12  ">
                                  <label for="inputEmail4">Fecha de Tasa</label>
                                  <input type="date" class="form-control" required value="@php echo date('Y-m-d')  @endphp" name="fecha" id="fecha" placeholder="referencia">
                                </div>
                    



                         
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->


                    <div class="card-footer row" id="card-footer">
                        @csrf
                        <div class="col-md-2">
                        </div>
    
                        <div class="col-md-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>
    
                            <div class="btn-group float-left">
                                <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                            </div>
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
