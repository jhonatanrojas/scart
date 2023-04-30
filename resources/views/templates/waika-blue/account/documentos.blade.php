
@extends($sc_templatePath.'.layout')
@section('block_main')
<section class="section">
    
<div class="container">
  <div class="row ">
    <div class="col-12 col-md-4">
      @include($sc_templatePath.'.account.nav_customer')
    </div>

    <div class="col-12 col-md-8">
      <form action="{{route('enviar_document')}}"  method="post" enctype="multipart/form-data">
      <div class="row gap-3 mb-4 estilos_card justify-content-center">
          @csrf
          <div class=" col-md-12">
              <label class="form-label" for="cedula">Adjuntar cedula</label>
              <input value="" name="cedula" type="file" class="form-control" id="Cedula">
            @error('cedula')
              <small style="color: red">{{$message}}</small>
            @enderror

            @if (empty($documentos['cedula']))
              <input type="hidden" name="c_vacio" value="cedula">
              @if (isset($documentos['id']))
                <input type="hidden" name="id" value="{{$documentos['id']}}">
              @endif
            @endif
          </div>
          
          <div class=" col-md-12">
              <label class="form-label" for="rif"> Adjuntar RIF</label>
              <input name="rif" type="file" class="form-control" id="rif">

            @error('rif')
            <small style="color: red">{{$message}}</small>
            @enderror

            @if (empty($documentos['rif']))
              <input type="hidden" name="r_vacio" value="rif">
              @if (isset($documentos['id']))
                <input type="hidden" name="id" value="{{$documentos['id']}}">
              @endif
            @endif
          </div>
          
          <div class=" col-12 col-md-12">
              <label class="form-label" for="carta_trabajo">Constancia de  trabajo</label>
              <input name="carta_trabajo" type="file" class="form-control" id="carta_trabajo">

            @error('carta_trabajo')
            <small style="color: red">{{$message}}</small>
            @enderror

            @if (empty($documentos['carta_trabajo']))
              <input type="hidden" name="k_vacio" value="carta">
              @if (isset($documentos['id']))
                <input type="hidden" name="id" value="  {{$documentos['id']}}">
              @endif
            @endif
          </div>

          <div class="col-12 d-grid">
            <button id="guarda"  class="btn btn-primary">Guardar</button>
          </div>

          @if (!empty($documentos))
            <div class="row">
              @if (empty($documentos['cedula']))
                <div class="col-md-4">
                  <div class="">
                    <div class="alert alert-danger">
                      <span class="h6"> Disculpa tu cédula fue rechazada vuelva a carga la cédula</span>
                    </div>
                  </div>
                </div>
              @else
                <div class="col-md-4">
                  <img height="200" width="300" src="{{$documentos['cedula']}}" alt="">
                </div>
              @endif

              @if (empty($documentos['rif']))
                <div class="col-md-4">
                  <div class="">
                    <div class="alert alert-danger">
                      <span class="h6"> Disculpa tu rif fue rechazada vuelva a carga el  rif</span>
                    </div>
                  </div>
                </div>
              @else
                <div class="col-md-4">
                  <img height="200" width="300" src="{{$documentos['rif']}}" alt="">
                </div>
              @endif

              @if (empty($documentos['carta_trabajo']))
                <div class="col-md-4">
                  <div class="">
                    <div class="alert alert-danger">
                      <span class="h6"> Disculpa tu contancia de trabajo  fue rechazada vuelva a carga la contancia de trabajo</span>
                    </div>
                  </div>
                </div>
              @else
                <div class="col-md-4">
                  <img height="200" width="300" src="{{$documentos['carta_trabajo']}}" alt="">
                </div>
              @endif
            </div>
          @endif

          <input  type="hidden" name="first_name" value="{{$customer['first_name']}}">
          <input type="hidden" name="id_usu" value="{{$customer['id']}}">
          <input type="hidden" name="email" value="{{$customer['email']}}">
          <input type="hidden" name="phone" value="{{ $customer['phone'] }}">
        </div>
      </form>
    </div>

    <div class="col-12 col-md-4">
      <div class="">
        @if (isset($mensaje) && $mensaje != "")
          <div class="alert alert-danger">
            <span class="h6"> {{ $mensaje }} </span>
          </div>
        @endif
      </div>
    </div>

  </div>
</section>



@endsection