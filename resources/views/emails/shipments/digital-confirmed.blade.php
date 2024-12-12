@component('mail::message')
# {{ __('Thank you for your purchase! Please open your order to download your files.') }}

@component('mail::button', ['url' => $url])
{{ __('View your order') }}
@endcomponent

@component('mail::table')
| {{ __('Items available for download') }} |   |
| :----------- | ------------: |
@foreach($shipment->shipmentItems as $shipmentItem)
| **{{ $shipmentItem->orderItem->name }}** | {{ __('Now available') }} |
@endforeach
@endcomponent

{{ __('Thanks,') }}<br>
{{ config('app.name') }}
@endcomponent
