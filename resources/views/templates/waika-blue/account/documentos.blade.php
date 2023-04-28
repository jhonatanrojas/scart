


@extends($sc_templatePath.'.layout')
@section('block_main')
<section class=""> 
    <div class="container">
      <div class="row ">
        <div class="col-12  col-md-4">
          @include($sc_templatePath.'.account.nav_customer')
        </div>

        <div class="col-12 col-md-8">
          <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
                <div class="row gap-3">
                  @csrf
                  <div class="col">
                      <input  name="cedula" type="file" class="form-control" id="Cedula">
                      <label class="input-group-text" for="cedula">adjuntar Cedula</label>
                    @error('cedula')
                    <small style="color: red">{{$message}}</small>
                    @enderror
                  </div>
                
                  <div class="col">
                      <input name="rif" type="file" class="form-control" id="rif">
                      <label class="input-group-text" for="rif"> adjuntar Rif</label>
                    @error('rif')
                    <small style="color: red">{{$message}}</small>
                    @enderror
                  </div>
        
                  <div class="col-12">
                      <input name="carta_trabajo" type="file" class="form-control" id="carta_trabajo">
                      <label class="input-group-text" for="carta_trabajo">Constancia de  trabajo</label>
                    @error('carta_trabajo')
                    <small style="color: red">{{$message}}</small>
                    @enderror
                  </div>

                  <div class="col">
                      <button id="guarda"  class="btn btn-primary">Guardar</button>
                  </div>

                  <input  type="hidden" name="first_name" value="{{$customer['first_name']}}">
                  <input type="hidden" name="id_usu" value="{{$customer['id']}}">
                  <input type="hidden" name="email" value="{{$customer['email']}}">
                  <input type="hidden" name="phone" value="{{ $customer['phone'] }}">
                </div>
          </form>
        </div>

        <div class="col-12 col-md-8">
          <div class=" text-center ">
              @if (isset($mensaje) && $mensaje != "")
                <div class="alert alert-danger">
                  <span class="h6"> {{ $mensaje }} </span>
                </div>
              @endif
          </div>
        </div> 
      </div>
    </div>
</section>



@endsection