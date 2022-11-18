<script type="text/javascript">
  function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  }
  $('#shipping').change(function(){
    $('#total').html(formatNumber(parseInt({{ Cart::subtotal() }})+ parseInt($('#shipping').val())));
  });
</script>

<script src="{{ sc_file('js/sweetalert2.all.min.js') }}"></script>
<script>
      function alertJs(type = 'error', msg = '') {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      Toast.fire({
        type: type,
        title: msg
      })
    }

    function alertMsg(type = 'error', msg = '', note = '') {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true,
      });
      swalWithBootstrapButtons.fire(
        msg,
        note,
        type
      )
    }
</script>

<!--process cart-->
<script type="text/javascript">
  function addToCartAjax(id, instance = null, storeId = null){
    $.ajax({
        url: "{{ sc_route('cart.add_ajax') }}",
        type: "POST",
        dataType: "JSON",
        data: {
          "id": id,
          "instance":instance,
          "storeId":storeId,
          "_token":"{{ csrf_token() }}"
        },
        async: false,
        success: function(data){
          // console.log(data);
            error = parseInt(data.error);
            if(error ==0)
            {
              setTimeout(function () {
                if(data.instance =='default'){
                  $('.sc-cart').html(data.count_cart);
                }else{
                  $('.sc-'+data.instance).html(data.count_cart);
                }
              }, 1000);
              alertJs('success', data.msg);
            }else{
              if(data.redirect){
                window.location.replace(data.redirect);
                return;
              }
              alertJs('error', data.msg);
            }

            }
    });
  }
</script>
<!--//end cart -->


<!--message-->
@if(Session::has('success'))
<script type="text/javascript">
    alertJs('success', '{!! Session::get('success') !!}');
</script>
@endif

@if(Session::has('error'))
<script type="text/javascript">
  alertJs('error', '{!! Session::get('error') !!}');
</script>
@endif

@if(Session::has('warning'))
<script type="text/javascript">
  alertJs('error', '{!! Session::get('warning') !!}');
</script>
@endif
<!--//message-->

{{-- image file manager --}}
<script type="text/javascript">
  (function( $ ){
  
        $.fn.filemanager = function(type, options) {
          type = type || 'other';
  
       
          this.on('click', function(e) {
            type = $(this).data('type') || type;//sc
            var route_prefix = (options && options.prefix) ? options.prefix : '/customer/uploads';
            var target_input = $('#' + $(this).data('input'));
            var target_preview = $('#' + $(this).data('preview'));
            window.open(route_prefix + '?type=' + type, '{{ sc_language_render('admin.file_manager') }}', 'width=900,height=600');
         console.log(route_prefix + '?type=' + type, '{{ sc_language_render('admin.file_manager') }}')
            window.SetUrl = function (items) {
              var file_path = items.map(function (item) {
                return item.url;
              }).join(',');
  
              // set the value of the desired input to image url
              target_input.val('').val(file_path).trigger('change');
  
              // clear previous preview
              target_preview.html('');
  
              // set or change the preview image src
              items.forEach(function (item) {
                target_preview.append(
                  $('<img>').attr('src', item.thumb_url)
                );
              });
  
              // trigger change event
              target_preview.trigger('change');
            };
            return false;
          });
        }
  
      })(jQuery);
  
      $('.lfm').filemanager();
  </script>
  {{-- //image file manager --}}
  