<?php

namespace ErenMustafaOzdal\LaravelContactModule\Events\Contact;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DestroySuccess extends Event
{
    use SerializesModels;

    public $model;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
