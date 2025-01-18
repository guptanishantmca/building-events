<?php 
namespace Tests\Feature;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function test_user_registered_event_is_triggered()
    {
        Event::fake(); // Fake all events

        // Create a user (ensure you have a User factory defined)
        $user = User::factory()->create();

        // Trigger the event
        event(new UserRegistered($user));

        // Assert that the event was fired
        Event::assertDispatched(UserRegistered::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }
}
