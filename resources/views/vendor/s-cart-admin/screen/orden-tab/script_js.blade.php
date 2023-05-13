
<script type="text/javascript">

    $('.mostrar_estatus_pago').click(function(){
      $("#modal_estatus_pago").modal('show');
    
      $("#id_pago").val($(this).data('id'))
      
    
        });
    
    function abrir_modal(){
    
      gen_table(false)
    }
    
    function formatoFecha(fecha, formato) {
        const map = {
            dd: fecha.getDate(),
            mm: fecha.getMonth() + 1,
            yy: fecha.getFullYear().toString().slice(-2),
            yyyy: fecha.getFullYear()
        }
    
        return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched])
    }
    
    function obtener_detalle_pago(id_pago){
    
      $.ajax({
                    url : '{{ sc_route_admin('obtener_pago') }}',
                    type : "get",
                    dateType:"application/json; charset=utf-8",
                    data : {
                         id : id_pago,
                        
                    },
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(returnedData){
               $('#modal_detalle_pago').modal('show')
    
               var data = returnedData.data;
    
                let fechas =  data.fecha_pago.split(' ')
    
               fechaInicio = new Date(document.getElementById('mfecha').value = fechas[0])
              
               $("#idpago").val(data.id)
               $("#order_id").val(data.order_id)
    
    
               
                $("#mforma_pago").val(data.metodo_pago_id)
                $("#mreferencia").val(data.referencia)
                $("#mvencimiento").val(data.fecha_venciento)
                $("#mmonto").val(data.importe_pagado)
           
                $("#mdivisa").val(data.moneda)
                $("#mobservacion").val(data.comment)
                $("#mstatus").val(data.payment_status)
                $("#mtasa").val(data.tasa_cambio)
                $("#dcomprobante").attr('href', data.comprobante)
                
    
                
    
                
                    $('#loading').hide();
                    
                    }
                });
            
    
    }
    
    function gen_table(fecha_p=false){
    var con_inicia = {!! json_encode($monto_Inicial  == 'Undefined' ? $order->details: $monto_Inicial) !!};
    var Monto_product = {!! json_encode($order->details  == 'Undefined' ? 0: $order->details) !!};

    var monto_cuota_entregas = {!! json_encode($monto_entrega) !!};

    
 
         
   
        $.ajax({
                    url : '{{ sc_route_admin('obtener_orden') }}',
                    type : "get",
                    dateType:"application/json; charset=utf-8",
                    data : {
                         id : '{{ $order->id }}',
                        
                    },
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(returnedData){
                  
                  $("#modal_convenio").modal('show')
                  $('#loading').hide();
                  $("#c_monto").val(returnedData.subtotal)
                  $("#c_nro_coutas").val(returnedData.details[0].nro_coutas )
                  $("#c_modalidad").val(returnedData.details[0].id_modalidad_pago  ==3 ?'Mensual' : 'Quincenal' )
                  $("#c_inicial").val(Math.floor(returnedData.subtotal * returnedData.details[0].abono_inicial/100))

                 
                
                  if(fecha_p==false){
                    if(returnedData.fecha_primer_pago ==null){
                      const hoy = new Date();
    
                     var fecha = new Date(); //Fecha actual
                var mes = fecha.getMonth()+1; //obteniendo mes
                var dia = fecha.getDate(); //obteniendo dia
                var ano = fecha.getFullYear(); //obteniendo año
                if(dia<10)
                  dia='0'+dia; //agrega cero si el menor de 10
                if(mes<10)
                  mes='0'+mes //agrega cero si el menor de 10
            
                 
                      $("#c_fecha_inicial").val(ano+"-"+mes+"-"+dia)
                      fechaInicio = new Date(fechaInicio)
    
                    }else{
    
                   
                      $("#c_fecha_inicial").val(returnedData.fecha_primer_pago)
                    fechaInicio = new Date(returnedData.fecha_primer_pago)
    
                    }
                   
                      }else{
                        fechaInicio = new Date($("#c_fecha_inicial").val())
                      }
       
                  
                  document.getElementById("tbodyconvenio").innerHTML="";
              document.getElementById("butto_modal").disabled = false;
             const monto_cuota_entrega= parseFloat(returnedData.details[0].monto_cuota_entrega)

              let monto=Number(returnedData.subtotal - monto_cuota_entrega);
              let n2=Number(returnedData.details[0].nro_coutas);
              let n3=Number(returnedData.details[0].abono_inicial);
              let inicial = parseInt(n3);
              if(inicial>0){ 
                totalinicial=(inicial*monto)/100;
                monto = monto -totalinicial;
              }
              var total_inicial= (returnedData.details[0].abono_inicial)
              var selected =returnedData.details[0].id_modalidad_pago;
              var selectd2 =returnedData.details[0].id_modalidad_pago  ==3 ?'Mensual' : 'Quincenal';
           
          
              
              fechaInicio.setDate(fechaInicio.getDate() + 1) // fecha actual
    
              if(fechaInicio == "Invalid Date"){
                var fechaInicio  = new Date();
                var fechaInicio = fechaInicio.toLocaleDateString('en-US');
                // obtener la fecha de hoy en formato `MM/DD/YYYY`
              }
             
    
              let periodo = selected;
              let totalPagos ,  plazo ,fechaPago;
              var primerFechaPago = true;
    
              if(monto>0){ 
                document.getElementById("cuotass").innerHTML= `CUOTAS $/${selectd2}`;
                
                if ( true ) {
                  plazo = n2
                } else {
                  alert('No seleccionaste ningún tipo de plazo')
                }
    
         
                switch ( periodo ) {
                  case 1:
                    let fechaFin = new Date(fechaInicio)
                    fechaFin.setMonth(fechaFin.getMonth() + parseInt(plazo))
                    let tiempo = fechaFin.getTime() - fechaInicio.getTime()
                    let dias = Math.floor(tiempo / (1000 * 60 * 60 * 24))
                    totalPagos = Math.ceil(dias / 7)
                    break
                  case 2:
                    totalPagos = plazo * 2
                    break
                  case 3:
                    totalPagos = plazo
                    
                    break
                  default:
                    alert('No seleccionaste ningún periodo de pagos')
                    break
                }
    
               
                let  montoTotal = monto
                  var cuotaTotal = monto / n2
                  let Inicial = montoTotal/inicial
                  Inicial == Infinity ? Inicial = 0 : Inicial
                  let Precio_cuota = 0
                  
                 if(con_inicia > 0 && monto_cuota_entregas >0){
                  montoTotal = Monto_product[0].total_price
                  Inicial = montoTotal/con_inicia

                  Precio_cuota = Math.floor(((Monto_product[0].total_price - con_inicia) - monto_cuota_entregas) / n2 ) ;
                  cuotaTotal = Precio_cuota

                 }

                var texto=0;
                for(i=1;i<=n2;i++){  
                  texto = (i + 1)
    
                  if ( primerFechaPago == true ) {
                      fechaPago = new Date(fechaInicio)
                      primerFechaPago = false
                    } else {
                      if ( periodo == '1' ) {
                        fechaPago.setDate(fechaPago.getDate() + 7)
                      } else if ( periodo == '2' ) {
                        fechaPago.setDate(fechaPago.getDate() + 15)
                      } else if ( periodo == '3' ) {
                        fechaPago.setMonth(fechaPago.getMonth() + 1)
                      }
                    }
    
                var mesf = fechaPago.getMonth()+1; //obteniendo mes
                var diaf = fechaPago.getDate(); //obteniendo dia
                var anof = fechaPago.getFullYear(); //obteniendo año
                if(diaf<10)
                diaf='0'+diaf; //agrega cero si el menor de 10
                if(mesf<10)
                mesf='0'+mesf; //agrega cero si el menor de 10
    
                
    
                      monto -= cuotaTotal
                      ca=monto;
                      d1=ca.toFixed(2) ;
                      i2= Inicial.toFixed(2);
                      d2=cuotaTotal.toFixed(2);
                      r=ca;
                      deudas = ((n2 + i2 - ca ) ) ;
                      d3=r.toFixed(2);
                      deuda=deudas.toFixed(1);
                      document.getElementById("tbodyconvenio").innerHTML=document.getElementById("tbodyconvenio").innerHTML+
                      `
                              <tr>
                                  <td>${i}</td>
                                  <td> <input readonly class="form-control" name="coutas_calculo[]" type="text" value="${d2}"> </td>
                                  <td> ${d3} </td>
                                  <td> <input   class="form-control"  name="fechas_pago_cuotas[]" type="date" value="${ anof+"-"+mesf+"-"+diaf}"> </td>
                              </tr>`;
                  }
                  n1= monto/n2;
                  t_i=i2*n2;
                  d4=t_i.toFixed(2);
                  t_p=r*n2;
                  d5=t_p.toFixed(2);
        
     
                  
                  
    
              }else{
                  alert("Falta ingresar un Número");
              }
    
                    $('#loading').hide();
                      
                    }
                });
            
    
            
    
          }
    function update_total(e){
        node = e.closest('tr');
        var qty = node.find('.add_qty').eq(0).val();
        var price = node.find('.add_price').eq(0).val();
        node.find('.add_total').eq(0).val(qty*price);
    }
    
     function  validar(element){
    
      node = element.closest('tr');
      var id = node.find('option:selected').eq(0).val();
     }
    //Add item
        function selectProduct(element){
            node = element.closest('tr');
            var id = node.find('option:selected').eq(0).val();
            if(!id){
                node.find('.add_sku').val('');
                node.find('.add_qty').eq(0).val('');
                node.find('.add_price').eq(0).val('');
                node.find('.add_attr').html('');
                node.find('.add_tax').html('');
            }else{
                $.ajax({
                    url : '{{ sc_route_admin('admin_order.product_info') }}',
                    type : "get",
                    dateType:"application/json; charset=utf-8",
                    data : {
                         id : id,
                         order_id : '{{ $order->id }}',
                    },
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(returnedData){
                  
    
                    node.find('.add_sku').val(returnedData.sku);
                    node.find('.add_qty').eq(0).val(1);
    
                    node.find('.add_nro_cuota').eq(0).val(returnedData.nro_coutas);
                    node.find('.add_serial').eq(0).val(returnedData.serial);
    
                  
                    var inicial=0;


                    if (parseFloat(returnedData.monto_inicial)>0){
                      inicial=  (parseFloat(returnedData.monto_inicial) *100) / parseFloat(returnedData.price_final)
                      
                    }    
                    var monto_iniciaL= parseFloat((returnedData.price_final-returnedData.monto_inicial) /returnedData.nro_coutas);
                    node.find('.monto_cuota_text').eq(0).text("$"+monto_iniciaL.toFixed(2));
                    
                    node.find('.add_inicial ').eq(0).val(inicial.toFixed(2));
                    if(!{!!$order->exchange_rate!!} == 0) node.find('.add_price').eq(0).val(returnedData.price_final * {!! $order->exchange_rate!!});
                      else node.find('.add_price').eq(0).val(returnedData.price_final)
    
                    if(!{!!$order->exchange_rate!!} == 0)
                      node.find('.add_total').eq(0).val(returnedData.price_final * {!! ($order->exchange_rate)??1!!});
                      else node.find('.add_total').eq(0).val(returnedData.price_final );
    
                    node.find('.add_attr').eq(0).html(returnedData.renderAttDetails);
    
                    node.find('.add_tax').eq(0).html(returnedData.tax);
                    
                    $('#loading').hide();
                    
                    }
                });
            }
    
        }
    
    $("#modalidad_de_compra" ).change(function(e) {
      let name = "modalidad_de_compra"
      let valor = $('#modalidad_de_compra').val()
      selectProduct2(name , valor)
    
    });
    
    $( "#evaluacion_comercial" ).change(function(e) {
      let name = "evaluacion_comercial"
      let valor = $('#evaluacion_comercial').val()
      selectProduct2(name , valor)
    
    });
    $( "#evaluacion_financiera" ).change(function(e) {
      let name = "evaluacion_financiera"
      let valor = $('#evaluacion_financiera').val()
      selectProduct2(name , valor)
    
    });
    $( "#evaluacion_legal" ).change(function(e) {
      let name = "evaluacion_legal"
      let valor = $('#evaluacion_legal').val()
      selectProduct2(name , valor)
    
    });
    $( "#decision_final" ).change(function(e) {
      let name = "decision_final"
      let valor = $('#decision_final').val()
      selectProduct2(name , valor)
    
    });
    
    
        function selectProduct2(name , valor){
             $.ajax({
              dataType: "json",
              data: { 
                id : '{{ $order->id }}',
                _token: '{{ csrf_token() }}',
                value:valor,
                nombre:name
              }, 
              url: `{{ route("admin_order.update") }}`,
              type: "post",
              beforeSend: function(){
                    $('#loading').show();
                    
                    
                },
      
                success: function (respuestas) {
                 
                  
                   
                  $('#loading').hide();
    
                 
                  
    
                     
              },
              error: function (xhr, err) {
                alert(
                  "readyState =" +
                    xhr.readyState +
                    " estado =" +
                    xhr.status +
                    "respuesta =" +
                    xhr.responseText
                );
                alert("ocurrio un error intente de nuevo");
              },
            });
    
           
            
    
        }
    
    
    
    
    $('#add-item-button').click(function() {
      var html = '{!! $htmlSelectProduct !!}';
      $('#add-item').before(html);
      $('.select2').select2();
      $('#add-item-button-save').show();
    });
    
    $('#add-item-button-save').click(function(event) {
        $('#add-item-button').prop('disabled', true);
        $('#add-item-button-save').button('loading');
        $.ajax({
            url:'{{ route("admin_order.add_item") }}',
            type:'post',
            dataType:'json',
            data:$('form#form-add-item').serialize(),
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(result){
              $('#loading').hide();
                if(parseInt(result.error) ==0){
                  location.reload();
                }else{
                  alertJs('error', result.msg);
                }
            }
        });
    });
    
    //End add item
    //
    
    $(document).ready(function() {
      all_editable();
    });
    
    function all_editable(){
        $.fn.editable.defaults.params = function (params) {
            params._token = "{{ csrf_token() }}";
            return params;
        };
    
        $('.updateInfo').editable({
          success: function(response) {
            if(response.error ==0){
              alertJs('success', response.msg);
        
            } else {
              alertJs('error', response.msg);
            }
        }
        });
    
        $(".updatePrice").on("shown", function(e, editable) {
          var value = $(this).text().replace(/,/g, "");
          editable.input.$input.val(parseInt(value));
        });
    
        var valor_estatus='';
        $('.updateStatus').editable({
            validate: function(value) {
              valor_estatus=value;
                if (value == '') {
                    return 'vacio';
                }
            },
            success: function(response) {
     
              if(response.error ==0){
                alertJs('success', response.msg);
               
                if(valor_estatus==5 ){
               
                    gen_table(false)
                    }
                    
              } else {
                alertJs('error', response.msg);
                location.reload()
                
              }
          }
        });
    
        $('.updateInfoRequired').editable({
            validate: function(value) {
                if (value == '') {
                    return 'vacio';
                }
            },
            success: function(response,newValue) {
              console.log(response.msg);
              if(response.error == 0){
                alertJs('success', response.msg);
                location.reload();
              } else {
                alertJs('error', response.msg);
              }
          }
        });
    
    
        $('.edit-item-detail').editable({
            ajaxOptions: {
            type: 'post',
            dataType: 'json'
            },
            validate: function(value) {
              if (value == '') {
                  return 'vacio';
              }
              if (!$.isNumeric(value)) {
                  return '{{  sc_language_render('admin.only_numeric') }}';
              }
            },
            success: function(response,newValue) {
                if(response.error ==0){
                    $('.data-shipping').html(response.detail.shipping);
                    $('.data-received').html(response.detail.received);
                    $('.data-subtotal').html(response.detail.subtotal);
                    $('.data-tax').html(response.detail.tax);
                    $('.data-total').html(response.detail.total);
                    $('.data-shipping').html(response.detail.shipping);
                    $('.data-discount').html(response.detail.discount);
                    $('.item_id_'+response.detail.item_id).html(response.detail.item_total_price);
                    var objblance = $('.data-balance').eq(0);
                    objblance.before(response.detail.balance);
                    objblance.remove();
                    alertJs('success', response.msg);
                    location.reload();
                } else {
                  alertJs('error', response.msg);
                }
            }
    
        });
    
        $('.updatePrice').editable({
            ajaxOptions: {
            type: 'post',
            dataType: 'json'
            },
            validate: function(value) {
              if (value == '') {
                  return '{{  sc_language_render('admin.not_empty') }}';
              }
              if (!$.isNumeric(value)) {
                  return '{{  sc_language_render('admin.only_numeric') }}';
              }
           },
    
            success: function(response, newValue) {
                  if(response.error ==0){
                      $('.data-shipping').html(response.detail.shipping);
                      $('.data-received').html(response.detail.received);
                      $('.data-subtotal').html(response.detail.subtotal);
                      $('.data-tax').html(response.detail.tax);
                      $('.data-total').html(response.detail.total);
                      $('.data-shipping').html(response.detail.shipping);
                      $('.data-discount').html(response.detail.discount);
                      var objblance = $('.data-balance').eq(0);
                      objblance.before(response.detail.balance);
                      objblance.remove();
                      alertJs('success', response.msg);
                      location.reload();
                  } else {
                    alertJs('error', response.msg);
                  }
          }
        });
    }
    
    
    {{-- sweetalert2 --}}
    function deleteItem(id){
      Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true,
      }).fire({
        title: '{{ sc_language_render('action.delete_confirm') }}',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
        confirmButtonColor: "#DD6B55",
        cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
        reverseButtons: true,
    
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("admin_order.delete_item") }}',
                    data: {
                      'pId':id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                      if(response.error ==0){
                       
                        alertJs('success', response.msg);
                        location.reload();
                    } else {
                      alertJs('error', response.msg);
                    }
                      
                    }
                });
            });
        }
    
      }).then((result) => {
        if (result.value) {
          alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}' );
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
          // swalWithBootstrapButtons.fire(
          //   'Cancelled',
          //   'Your imaginary file is safe :)',
          //   'error'
          // )
        }
      })
    }
    {{--/ sweetalert2 --}}
    
    
      $(document).ready(function(){
      // does current browser support PJAX
        if ($.support.pjax) {
          $.pjax.defaults.timeout = 2000; // time in milliseconds
        }
    
      });
    
      function order_print(){
        $('.not-print').hide();
        window.print();
        $('.not-print').show();
      }
    
    
    function abrir_modal_convenio(event){
        event.preventDefault()
        gen_table(fecha_p=false)
    }
    
     

    
      const routes = {
      "{{ route('borrador_pdf', ['id' => $order->id]) }}": "_blank",
      "{{ route('editar_convenio_cliente', ['id' => $order->id]) }}": "_blank",
      "{{ route('downloadPdf', ['id' => $order->id]) }}": "_blank",
      "{{ sc_route_admin('ficha_pedido', ['order_id' => $order->id]) }}": "_blank",
      "{{ route('downloadJuradada', ['id' => $order->id]) }}": "_blank",
      "{{ sc_route_admin('admin_order.invoice', ['order_id' => $order->id])}}": "_blank",
      "{{ sc_route_admin('propuesta', ['order_id' => $order->id])}}": "_blank",
      "convenio_modal": null, 
    };
    
    //funcion para eliminar una pago de sc_historial_pagos via ajax jquery historial_pagos.delete
    var styleStatusPaymentString =  $("#styleStatusPayment").val()
    var styleStatusPayment = JSON.parse(styleStatusPaymentString );

    function deleteItemPago(id) {
      Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true,
      }).fire({
        title: '{{ sc_language_render('action.delete_confirm') }}',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
        confirmButtonColor: "#DD6B55",
        cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
        reverseButtons: true,
    
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    method: 'POST',
                    url: '{{ route("historial_pagos.delete") }}',
                    data: {
                      'pId':id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                      if(response.error ==0){
                       
                        alertJs('success', response.msg);
                        obtener_historial_pagos()
                    } else {
                      alertJs('error', response.msg);
                    }
                      
                    }
                });
            });
        }
    
      }).then((result) => {
        if (result.value) {
          alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}' );
        
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
          // swalWithBootstrapButtons.fire(
          //   'Cancelled',
          //   'Your imaginary file is safe :)',
          //   'error'
          // )
        }
      })
    }
    
    function obtener_historial_pagos(){
      console.log('obtener_historial_pagos');
      let= total_pagado =0; 
      const  order_total="{{ $order->total }}";
      let total_pendiente=0;
      $.ajax({
        method: 'get',
        url: '{{ route("getPagosAjax") }}',
        data: {
          'pId':"{{ $order->id }}",
            _token: '{{ csrf_token() }}',
        },

 
        success: function (response) {
        
    
            $('#tablerecibos > tbody').empty();
           
            response.forEach(function (historial) {
        let acciones = '';
        if (historial.payment_status === 5 || historial.payment_status === 6 || historial.payment_status === 4 || historial.payment_status === 3 ) {
        total_pagado +=parseFloat(historial.importe_couta);
        }
        if (historial.payment_status === 2) {
            acciones += '<a href="#" data-id="' + historial.id + '"><span data-id="' + historial.id + '" title="Cambiar estatus" type="button" class="btn btn-flat mostrar_estatus_pago btn-sm btn-primary"><i class="fa fa-edit"></i></span></a>';
        }
        if (historial.payment_status === 2 || historial.payment_status === 5 || historial.payment_status === 6 || historial.payment_status === 4 || historial.payment_status === 3)  {
            acciones += '<a href="#" onclick="obtener_detalle_pago(' + historial.id + ')"><span title="Detalle del pago" type="button" class="btn btn-flat btn-sm btn-success"><i class="fas fa-search"></i></span></a>';
        }
        if (historial.payment_status !== 2 && historial.payment_status !== 5 && historial.payment_status !== 6 && historial.payment_status !== 4 && historial.payment_status !== 3) {
            acciones += '<a href="{{route("historial_pagos.reportar")}}?id='+historial.order_id+'&id_pago=' + historial.id + '"><span title="Reportar pago" type="button" class="btn btn-flat btn-sm btn-info"><i class="fa fa-credit-card"></i></span></a>';
        }
        if ( historial.payment_status !== 5 && historial.payment_status !== 6 && historial.payment_status !== 4 && historial.payment_status !== 3) {
        acciones += ' <a href="#"><span onclick="deleteItemPago(' + historial.id + ');" title="Eliminar" class="btn btn-flat btn-sm btn-danger"><i class="fas fa-trash-alt"></i></span></a>';
        total_pendiente++;
      }

        const tasaCambio = historial.tasa_cambio ? historial.tasa_cambio : 1;
        const importeCalculado = historial.moneda === 'USD' ? round(historial.importe_pagado * tasaCambio, 2) : round(historial.importe_pagado / tasaCambio, 2);
        const importeCalculadoCurrency = historial.moneda === 'USD' ? 'bs' : '$';

        const fila = '<tr>' +

        '<td>' +  historial.nro_coutas + '</td>' +
            '<td>' + acciones + '</td>' +
            '<td><span class="item_21_sku">' + historial.importe_couta + ' $</span></td>' +
            '<td><span class="item_21_sku">' + historial.importe_pagado + '</span></td>' +
            '<td><span class="item_21_sku">' + historial.moneda + '</span></td>' +
            '<td><span class="item_21_sku">' + importeCalculado + ' ' + importeCalculadoCurrency + '</span></td>' +
            '<td><span class="item_21_sku">' + styleStatusPayment[historial.payment_status]+ '<br><small>' +
            (historial.referencia  ?   historial.referencia :'') + ' - </small></span></td>' +
            '<td><span class="item_21_sku">' + historial.fecha_venciento + '</span></td>' +
            '<td><span class="item_21_sku">' + (historial.comment  ?  historial.comment :'') + ' / ' + historial.observacion + '</span></td>' +
            '</tr>';

            $('#tablerecibos > tbody').append(fila);
    });

    const html = `
    <tr>
        <td></td>
        <th colspan="1">
            Total Pagado
        </th>
        <th>
            <span class="item_21_sku">${total_pagado}$</span>
        </th>
        <th>
            Cuotas Pendiente: ${total_pendiente}
        </th>
        <th>
            <span class="item_21_sku">Por Pagar: ${ parseFloat(order_total -total_pagado).toFixed(2) }$</span>
            <br>
        </th>
    </tr>
`;
    $('#tablerecibos > tbody').append(html);
          
        }
      });
    }



       function round(number, precision) {
        const factor = Math.pow(10, precision);
        return Math.round(number * factor) / factor;
    }

    function fechaEuropea(dateString) {
        const date = new Date(dateString);
        return ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
    }

    // funcion para crear un nuevo pago de sc_historial_pagos via ajax jquery historial_pagos.create
    function crear_recibo() {
      var nro_couta_modal = $('#nro_couta_modal').val();
      var monto_couta_modal = $('#monto_couta_modal').val();
      var fecha_vencimiento_modal = $('#fecha_vencimiento_modal').val();
            //validar los inputs nro_couta_modal monto_couta_modal fecha_vencimiento_modal
      if(nro_couta_modal == '' || monto_couta_modal == '' || fecha_vencimiento_modal == ''){
        alertJs('error', 'Debe llenar todos los campos');
        return false;
      }

      $.ajax({
        method: 'POST',
        url: '{{ route("historial_pagos.postCreate") }}',
        data: {
          'order_id':"{{ $order->id }}",
          'importe_couta':monto_couta_modal,
          'nro_couta':nro_couta_modal,
          'fecha_vencimiento':fecha_vencimiento_modal,
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
          if(response.error ==0){
            alertJs('success', response.msg);
            obtener_historial_pagos()
        } else {
          alertJs('error', response.msg);
        }
          
        }
      });
      $('#modalNuevoRecibo').modal('hide');

    }
    </script>
    

    