<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conversation;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;
    public $user;
    public $userToNotify;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation, $user, $userToNotify)
    {
        $this->conversation = $conversation;
        $this->user = $user;
        $this->userToNotify = $userToNotify;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {   
        //dd($this->userToNotify);
        return new PrivateChannel('chat.'. $this->userToNotify["user"]["id"]);
    }

    public function broadcastAs() {
        return 'New message';
   }
}
