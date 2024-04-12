@extends('emails.layouts.base')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="ag-mail-tableset">{{ __('front/cart.pozdrav') }} {{ $order->payment_fname }}  {{ __('front/cart.hvala') }}</td>
        </tr>
        <tr>
            <td class="ag-mail-tableset"> <h3 style="line-height:0px">{{ __('front/cart.narudzba_broj') }}: {{ $order->id }} </h3></td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
            </td>
        </tr>
        <tr>
            <td class="ag-mail-tableset">
                <b> {{ __('front/cart.nacin_placanja') }}:</b>
                <b>{{ __('Stripe') }}</b>
                <p style="font-size:12px">{{ __('front/cart.sb1') }} {{ $order->id }} {{ __('front/cart.sb2') }}.</p>
                <br><br>

                {{ __('front/cart.lp') }}<br>GoFlexi
            </td>
        </tr>

    </table>
@endsection
