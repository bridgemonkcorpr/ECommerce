<?php

namespace App\Events;

use App\Models\Shipment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShipmentCreated
{
//Yeh event tab trigger hota hai jab ek shipment create hota hai, aur iska use real-time updates dene ke liye kiya jaa sakta hai. Jaise hi shipment create hota hai, aap yeh event broadcast kar sakte ho taaki user ko shipment ke status ki update mil sake.

    use Dispatchable  //Event ko dispatch karne ke liye use hota hai.
        , InteractsWithSockets // Event ko socket ke saath interact karne ke liye use hota hai.
        , SerializesModels;  //Isse models ko serialize kiya jaata hai jab event broadcast ho.


    /**
     * The shipment instance.
     *
     * Yeh property Shipment model ko store karti hai, jo event ke saath pass kiya jaata hai. Jab event trigger hota hai, to ek specific shipment object ko event ke saath send kiya jaata hai.
     * @var Shipment
     */
    public $shipment;

    /**
     * Create a new event instance.
     *
     * @return void
     * __construct(Shipment $shipment): Yeh method event ko initialize karta hai. Jab bhi event trigger hota hai, Shipment model ko $shipment property mein store kiya jaata hai. Isse aap specific shipment ki details ko access kar sakte ho.
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     * broadcastOn(): Yeh method specify karta hai ki event kis channel par broadcast hoga.

     * new PrivateChannel('channel-name'): Yeh ek private channel create karta hai jahan par yeh event broadcast hoga. Aap apne requirement ke hisaab se channel-name ko customize kar sakte hain.
     * Yeh method ek array return karta hai, jo multiple channels ke liye event ko broadcast karne ka option deta hai.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
