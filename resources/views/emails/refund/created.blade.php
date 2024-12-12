<x-mail::message>
# {{ __('You have received a refund') }}

{{ __('Total amount refunded: :amount', ['amount' => money($refund->amount, config('app.currency'))]) }}

@component('mail::table')
    | {{ __('Order #:id', ['id' => $order->id]) }} |   |   |
    | :----------- | :------------ | -----------: |
    @foreach($order->orderItems as $item)
        | **{{ $item->name }} x {{ $item->quantity }}** |  | **{{ money($item->subtotal, config('app.currency')) }}** |
    @endforeach
    |  | {{ __('Subtotal') }}  | **{{ money($order->subtotal, config('app.currency')) }}** |
    |  | {{ __('Shipping') }}  | **{{ money($order->shipping_price, config('app.currency')) }}** |
    |  | {{ __('Taxes') }}     | **{{ money($order->taxtotal, config('app.currency')) }}** |
    |  | {{ __('Total') }}     | **{{ money($order->total, config('app.currency')) }}** |
    |  | {{ __('Refund') }}     | **{{ money(-$refund->amount, config('app.currency')) }}** |
@endcomponent

@component('mail::table')
    | {{ __('Customer information') }} |   |   |
    | :---------- | :----------: | :---------- |
    | **{{ __('Shipping address') }}**<br>{{ $order->shippingAddress->name }}<br>{{ $order->shippingAddress->address }}<br>{{ $order->shippingAddress->city }} {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postcode }}<br>{{ $order->shippingAddress->country->name }} |  | **{{ __('Billing address') }}**<br>{{ $order->billingAddress->name }}<br>{{ $order->billingAddress->address }}<br>{{ $order->billingAddress->city }} {{ $order->billingAddress->state }} {{ $order->billingAddress->postcode }}<br>{{ $order->billingAddress->country->name }} |
    | **{{ __('Shipping method') }}**<br>{{ $order->shipping_rate }} |  | **{{ __('Payment method') }}**<br>{{ $order->paymentMethod->name }} |
@endcomponent

{{ __('Thanks,') }}<br>
{{ $generalSettings->store_name ?: config('app.name') }}
</x-mail::message>
