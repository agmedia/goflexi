<form name="pay" class="w-100" action="{{ $data['url'] }}" method="GET">
    <div class="d-flex mt-3">
        <div class="w-50 pe-3"><a class="btn button button-light d-block w-100" href="{{ route('index') }}"><i class="ci-arrow-left  me-1"></i><span class="d-none d-sm-inline">{{ __('front/checkout.backbtnpayment') }}</span><span class="d-inline d-sm-none">{{ __('front/checkout.backbtn') }}</span></a></div>
        <div class="w-50 ps-2">
            <button class="btn button btn-primary text-light d-block w-100" type="submit"><span class="d-none d-sm-inline">{{ __('front/checkout.finishorder') }}</span><span class="d-inline d-sm-none">{{ __('front/checkout.finishshoping') }}</span><i class="ci-arrow-right ms-1"></i></button>
        </div>
    </div>
</form>


