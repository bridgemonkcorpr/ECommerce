<?php

namespace App\Jobs\RazorpayWebhooks;

use App\Enums\PaymentStatus;
use App\Events\PaymentReceived;
use App\Events\RefundCreated;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessRazorpayWebhookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WebhookCall $webhookCall;

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
        if ($this->webhookCall->payload['event'] === 'order.paid') {
            $this->processOrderPaidEvent();
        }

        if ($this->webhookCall->payload['event'] === 'refund.created') {
            $this->processRefundCreatedEvent();
        }
    }

    public function processOrderPaidEvent()
    {
        $order = Order::query()->findOrFail($this->webhookCall->payload['payload']['order']['entity']['receipt']);

        $order->payments()->create([
            'reference' => $this->webhookCall->payload['payload']['payment']['entity']['id'],
            'amount' => $this->webhookCall->payload['payload']['payment']['entity']['amount'] / 100,
            'currency' => \Str::upper($this->webhookCall->payload['payload']['payment']['entity']['currency']),
            'status' => PaymentStatus::PAID,
        ]);

        $order->payment_status = PaymentStatus::PAID;

        $order->save();

        PaymentReceived::dispatch($order);
    }

    public function processRefundCreatedEvent()
    {
        $order = Order::query()->where('meta->razorpay_payment_id', $this->webhookCall->payload['payload']['refund']['entity']['payment_id'])->firstOrFail();

        if ($order->refunds()->where('meta->razorpay_refund_id', $this->webhookCall->payload['payload']['refund']['entity']['id'])->exists()) {
            return;
        }

        $refund = $order->refunds()->create([
            'amount' => $this->webhookCall->payload['payload']['refund']['entity']['amount'] / 100,
            'meta' => [
                'razorpay_refund_id' => $this->webhookCall->payload['payload']['refund']['entity']['id'],
            ]
        ]);

        RefundCreated::dispatch($refund);
    }
}
