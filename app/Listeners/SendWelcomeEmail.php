<?php
namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

 

class SendWelcomeEmail  
{
     
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        
        try {
            Mail::to($event->user->email)->send(new \App\Mail\WelcomeEmail($event->user));
            Log::info('Email successfully sent to: ' . $event->user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }
    }
}
