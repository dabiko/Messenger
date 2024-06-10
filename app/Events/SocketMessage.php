<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SocketMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Message $message)
    {
        //
    }

    /** Function to broadcast particular and not all info through the channels */
    public function broadcastWith(): array
    {
        return [
            'message' => new MessageResource($this->message),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
//        return [
//            new PrivateChannel('channel-name'),
//        ];

        $incomingMessage = $this->message;
        $channels = [];
        if ($incomingMessage->group_id){
           $channels[] = new PrivateChannel('message.group.' . $incomingMessage->group_id);
        }else{
            new PrivateChannel('message.user.' . collect([$incomingMessage->sender_id, $incomingMessage->receiver_id])
             ->sort()
             ->implode('-'));
        }

        return $channels;
    }
}
