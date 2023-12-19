<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminLiveChat implements ShouldBroadcast
{
    public $user_id;
    public $msg_user_admin;
    public $msg;
    public $img;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $msg_user_admin, $msg, $img)
    {
        $this->user_id = $user_id;
        $this->msg_user_admin =$msg_user_admin;
        $this->msg = $msg;
        $this->img = $img;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('admin-chat');
    }

    public function broadcastAs(){
        return 'admin_chats';
    }
}
