<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [
            new Channel('chat'), // General admin channel
        ];

        // Add session-specific public channel if session_id exists
        if ($this->chatMessage->session_id) {
            $channels[] = new Channel('chat.'.$this->chatMessage->session_id);
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->chatMessage->id,
            'user_name' => $this->chatMessage->user_name,
            'message' => $this->chatMessage->message,
            'is_admin' => $this->chatMessage->is_admin,
            'session_id' => $this->chatMessage->session_id,
            'created_at' => $this->chatMessage->created_at->toISOString(),
            'file_path' => $this->chatMessage->file_path,
            'file_name' => $this->chatMessage->file_name,
            'file_type' => $this->chatMessage->file_type,
            'file_size' => $this->chatMessage->file_size,
        ];
    }
}
