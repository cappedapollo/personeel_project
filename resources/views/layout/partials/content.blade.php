<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container">
        @php $wh = App\Models\CeleryWebhook::latest()->first(); @endphp
        @if ($wh)
        <div class="alert alert-custom alert-warning fade show" role="alert">
            <div class="alert-text">{{ $wh->msg }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
        @endif
        
        @yield('content')
    </div>
</div>
<!--end::Entry-->