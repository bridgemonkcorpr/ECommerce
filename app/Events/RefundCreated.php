<?php

namespace App\Events;

use App\Models\Refund;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefundCreated
{
//Yeh event tab trigger hota hai jab ek refund create hota hai, aur is event ko real-time notifications ke liye use kiya jaa sakta hai. Jaise hi refund process hota hai, aap yeh event broadcast kar sakte ho taaki user ko refund status ki update mil sake.
    use Dispatchable  //Event ko dispatch karne ke liye use hota hai.
        , InteractsWithSockets // Event ko socket ke saath interact karne ke liye use hota hai.
        , SerializesModels;  //Isse models ko serialize kiya jaata hai jab event broadcast ho.

//Yeh property event ke andar Refund model object ko store karti hai, jo event ke saath send kiya jaata hai. Matlab jab event trigger hoga, tab ek specific Refund object pass kiya jayega.
    public Refund $refund;

    /**
     * Create a new event instance.
     * __construct(Refund $refund): Yeh method event instance ko initialize karta hai aur Refund model ko $refund property mein store karta hai. Matlab jab event trigger hota hai, to ek specific Refund object pass kiya jayega.
     */
    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     *     broadcastOn(): Yeh method batata hai ki event kis channel par broadcast hoga. Is example mein:

     * new PrivateChannel('channel-name'): Yeh ek private channel create karta hai jahan par yeh event broadcast hoga. Aap channel-name ko apne required channel name se replace kar sakte hain.
     * Yeh method array return karta hai, jo multiple channels ke liye event broadcast karne ka option deta hai.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
