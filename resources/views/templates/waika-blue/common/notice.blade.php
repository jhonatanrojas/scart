<!--main right-->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="sc-notice">
                @if(Session::has('message') || Session::has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! Session::get('message') !!}
                        {!! Session::get('status') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
        
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! Session::get('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! Session::get('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        
                @if(Session::has('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {!! Session::get('warning') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
        
            </div>
        </div>
    </div>
</div>
<!--//main right-->
