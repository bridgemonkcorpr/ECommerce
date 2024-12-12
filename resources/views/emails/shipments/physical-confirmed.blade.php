@component('mail::message')
# {{ trans_choice('{1} One item in your order is on the way|{2,*} Some items in your order is on the way', $shipment->shipmentItems->count()) }}

{{ trans_choice('{1} One item in your order is on the way.|{2,*} Some items in your order is on the way.', $shipment->shipmentItems->count()) }} {{ __('Track your shipment to see the delivery status.') }}

@component('mail::button', ['url' => $url])
{{ __('View your order') }}
@endcomponent

@if($shipment->tracking_number)
@component('mail::panel')
 {{ $shipment->shipping_carrier == \App\Enums\ShippingCarrier::OTHER ? __('Tracking number: :tracking_number', ['tracking_number' => $shipment->tracking_number]) : __(':carrier tracking number: :tracking_number', ['carrier' => $shipment->shipping_carrier->label(), 'tracking_number' => $shipment->tracking_number]) }}
@endcomponent
@endif

@component('mail::table')
| {{ __('Items in this shipment') }} |   |
| :----------- | ------------: |
@foreach($shipment->shipmentItems as $shipmentItem)
| **{{ $shipmentItem->orderItem->name }}** | {{ trans(':shipmentQuantity of :orderQuantity', ['shipmentQuantity' => $shipmentItem->quantity, 'orderQuantity' => $shipmentItem->orderItem->quantity]) }} |
@endforeach
@endcomponent

{{ __('Thanks,') }}<br>
{{ $generalSettings->store_name ?: config('app.name') }}
@endcomponent
