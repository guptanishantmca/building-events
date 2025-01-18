<?php

namespace App\Mail\Auth;

use Illuminate\Mail\Mailable;

class BaseEmail extends Mailable
{
    public function __construct()
    {
        $this->from(config('mail.from.address'), config('mail.from.name'));
    }
}
