<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendBalance implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $userId;
  public $balance;

  public function __construct($userId, $balance,)
  {
    $this->userId = $userId;
    $this->balance = $balance;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn()
  {
    return new PrivateChannel('user.' . $this->userId);
  }

  public function broadcastAs()
  {
    return 'SendBalance';
  }

  public function broadcastWith()
  {
    return [
      'isWithdrawal' => true,
      'amount' => $this->balance
    ];
  }
}
