<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <div class="container">
        @auth
            $wh = App\Models\CeleryWebhook::where('company_id',  Auth::user()->company_user->company_id)->first();
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
        @endauth
        @yield('content')
    </div>
</div>
<!--end::Entry-->