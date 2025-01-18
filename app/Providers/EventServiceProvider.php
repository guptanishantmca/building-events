<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
 
 

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
 
    
    protected $listen = [
        \App\Events\UserRegistered::class => [
            \App\Listeners\SendWelcomeEmail::class,
        ],
    ];
    
    public function register(): void
    {
        //
      
    }
    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       // parent::boot();
      
        Event::listen(function (UserRegistered $event) {
            Log::info('UserRegistered event fired! provider file');
        });

        
    }
}
