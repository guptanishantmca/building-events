<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\User;

class UserRegistered
{
    use Dispatchable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}

 