<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated
{

//Yeh event tab trigger hota hai jab ek naya order create hota hai, aur yeh order data ko broadcast karne ke liye use kiya jaa sakta hai. Is event ka use real-time notifications ya live updates ke liye kiya jaa sakta hai, jaise admin ya user ko order creation ki information milna.
    use Dispatchable  //Event ko dispatch karne ke liye use hota hai.
        , InteractsWithSockets // Event ko socket ke saath interact karne ke liye use hota hai.
        , SerializesModels;  //Isse models ko serialize kiya jaata hai jab event broadcast ho.

    public $order;  //Yeh property event ke andar order object ko store karti hai, jo is event ke saath send kiya jaata hai.

    /**
     * Create a new event instance.
     *
     * @return void
     *
     * __construct(Order $order): Yeh method event instance ko initialize karta hai aur Order model ko $order property mein store karta hai. Matlab jab event trigger hoga, tab ek specific Order object pass kiya jayega.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     *
     * broadcastOn(): Yeh method batata hai ki event kis channel par broadcast hoga. Is example mein:
    * new PrivateChannel('channel-name'): Yeh ek private channel create karta hai jahan par yeh event broadcast hoga. Aap channel-name ko apne required channel name se replace kar sakte hain.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
