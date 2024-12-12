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

class PaymentReceived
{
//Yeh event tab trigger hota hai jab ek payment receive hoti hai aur yeh event Order model ke data ko broadcast karne ke liye use hota hai. Iska use real-time payment status update ya notifications ke liye kiya jaa sakta hai, jaise user ko payment confirm hone par notification bhejna.
    use Dispatchable  //Event ko dispatch karne ke liye use hota hai.
        , InteractsWithSockets // Event ko socket ke saath interact karne ke liye use hota hai.
        , SerializesModels;  //Isse models ko serialize kiya jaata hai jab event broadcast ho.


    //Yeh property event ke andar Order model object ko store karti hai, jo event ke saath send kiya jaata hai. Is case mein, jab payment receive hoti hai, to related order ko access kiya jaata hai.
    public Order $order;

    /**
     * Create a new event instance.
     *
     *  __construct(Order $order): Yeh method event instance ko initialize karta hai aur Order model ko $order property mein store karta hai. Matlab jab event trigger hoga, tab ek specific Order object pass kiya jayega.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
