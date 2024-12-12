<?php

namespace App\Jobs\StripeWebhooks;

use App\Enums\PaymentStatus;
use App\Events\PaymentReceived;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class HandleCheckoutSessionCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $webhookCall;

    /**
     * Create a new job instance.
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::query()->findOrFail($this->webhookCall->payload['data']['object']['client_reference_id']);

        $order->payments()->create([
            'reference' => $this->webhookCall->payload['data']['object']['payment_intent'],
            'amount' => $this->webhookCall->payload['data']['object']['amount_total'] / 100,
            'currency' => \Str::upper($this->webhookCall->payload['data']['object']['currency']),
            'status' => PaymentStatus::PAID->name,
        ]);

        $order->payment_status = PaymentStatus::PAID;

        $order->meta = array_merge($order->meta, ['stripe_payment_intent' => $this->webhookCall->payload['data']['object']['payment_intent']]);

        $order->save();

        PaymentReceived::dispatch($order);
    }
}
